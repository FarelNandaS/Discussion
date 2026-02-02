<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use App\Models\TrustScoreLog;
use App\Notifications\ReactionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReactionController extends Controller
{
    public function post(Request $request)
    {
        DB::beginTransaction();
        try {
            $post = Post::findOrFail($request->id);

            $reaction = Reaction::where('user_id', auth()->user()->id)->where('reactable_type', Post::class)->where('reactable_id', $post->id)->first();
            $count = 0;

            if ($reaction) {
                if ($reaction->type == $request->type) {
                    $reaction->delete();

                    $log = TrustScoreLog::where([
                        'user_action_id' => auth()->user()->id,
                        'reference_type' => Post::class,
                        'reference_id' => $post->id,
                    ])->first();

                    $post->user->detail->trust_score -= $log->change;

                    if ($post->user->detail->trust_score < 70) {
                        $post->user->detail->suspend_until = now()->addDays(7);
                    } else {
                        $post->user->detail->suspend_until = null;
                    }

                    $post->user->detail->save();

                    $log->delete();

                    if ($request->type == 'up') {
                        $post->decrement('up_vote_count');
                        $count = $post->up_vote_count;
                    } else if ($request->type == 'down') {
                        $post->decrement('down_vote_count');
                        $count = $post->down_vote_count;
                    }

                    $post->user->notifications()->where([
                        'data->type' => 'reaction',
                        'data->content_type' => Post::class,
                        'data->content_id' => $post->id,
                    ])->delete();

                    DB::commit();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'successfuly do reaction',
                        'count' => $count,
                    ]);
                } else {
                    $reaction->update(['type' => $request->type]);

                    $log = TrustScoreLog::where([
                        'user_action_id' => auth()->user()->id,
                        'reference_type' => Post::class,
                        'reference_id' => $post->id,
                    ])->first();

                    $post->user->detail->trust_score -= $log->change;

                    if ($request->type == 'up') {
                        $change = 2;
                        $reason = 'Your post with title "' . Str::limit($post->title, 30) . '" get a upvote';
                        $post->decrement('down_vote_count');
                        $post->increment('up_vote_count');
                    } else if ($request->type == 'down') {
                        $change = -1;
                        $reason = 'Your post with title "' . Str::limit($post->title, 30) . '" get a downvote';
                        $post->decrement('up_vote_count');
                        $post->increment('down_vote_count');
                    }

                    $post->user->detail->trust_score += $change;

                    if ($post->user->detail->trust_score < 70) {
                        $post->user->detail->suspend_until = now()->addDays(7);
                    } else {
                        $post->user->detail->suspend_until = null;
                    }

                    $post->user->detail->save();

                    $log->change = $change;
                    $log->reason = $reason;
                    $log->save();

                    $voteText = ($request->type == 'up') ? 'upvote' : 'downvote';

                    $post->user->notifications()->where([
                        'data->type' => 'reaction',
                        'data->content_type' => Post::class,
                        'data->content_id' => $post->id,
                    ])->update([
                                'data->reaction_type' => $request->type,
                                'data->title' => 'Your content with title "' . $post->title . '" get ' . $voteText . ' by ' . auth()->user()->username . '.',
                            ]);

                    DB::commit();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'successfuly do reaction',
                        'countUp' => $post->up_vote_count,
                        'countDown' => $post->down_vote_count,
                        'isChange' => true,
                    ]);
                }
            } else {
                Reaction::create([
                    'user_id' => auth()->user()->id,
                    'reactable_type' => Post::class,
                    'reactable_id' => $post->id,
                    'type' => $request->type
                ]);

                if ($request->type == 'up') {
                    $post->increment('up_vote_count');
                    $count = $post->up_vote_count;
                    $change = 2;
                    $reason = 'Your post with title "' . Str::limit($post->title, 30) . '" get a upvote';
                } else if ($request->type == 'down') {
                    $post->increment('down_vote_count');
                    $count = $post->down_vote_count;
                    $change = -1;
                    $reason = 'Your post with title "' . Str::limit($post->title, 30) . '" get a downvote';
                }

                $post->user->detail->trust_score += $change;

                if ($post->user->detail->trust_score < 70) {
                    $post->user->detail->suspend_until = now()->addDays(7);
                } else {
                    $post->user->detail->suspend_until = null;
                }

                $post->user->detail->save();

                TrustScoreLog::create([
                    'user_id' => $post->user->id,
                    'user_action_id' => auth()->user()->id,
                    'change' => $change,
                    'reason' => $reason,
                    'reference_type' => $post->getMorphClass(),
                    'reference_id' => $post->id,
                ]);

                $post->user->notify(new ReactionNotification($post, auth()->user(), $request->type));

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'successfuly do reaction',
                    'count' => $count,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
