<dialog id="report" class="modal">
  <div class="modal-box flex flex-col items-center gap-4 p-6 max-w-xl">
    <h3 class="text-xl font-bold text-center">Report Content</h3>
    <p class="text-sm text-gray-500 text-center">
      Help us keep the community safe by reporting inappropriate content.
    </p>

    <form id="reportForm" class="w-full space-y-4">
      <input type="hidden" id="reportable_type" name="reportable_type" value="">
      <input type="hidden" id="reportable_id" name="reportable_id" value="">

      <div>
        <label class="label mb-2">
          <span class="label-text">Reason for reporting</span>
        </label>
        <select name="reason_type" id="reason_type" class="select select-bordered w-full">
          <option value="" disabled selected>Select a reason</option>
          <option value="hate_speech">Hate speech or discrimination</option>
          <option value="harassment">Harassment or bullying</option>
          <option value="misinformation">False or misleading information</option>
          <option value="other">Other</option>
        </select>
      </div>

      <div>
        <label class="label mb-2">
          <span class="label-text">Additional details (optional)</span>
        </label>
        <textarea name="message" id="message" placeholder="Explain why you're reporting this..."
          class="textarea textarea-bordered w-full" rows="3"></textarea>
      </div>

      <div class="flex justify-end gap-2 w-full pt-2">
        <button type="button" class="btn" onclick="report.close()">Cancel</button>
        <button type="button" class="btn btn-error" onclick="submitReport()">Submit Report</button>
      </div>
    </form>
  </div>

  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<script>
  function showReport(type, id) {
    $('#reportable_type').val(type);
    $('#reportable_id').val(id);

    report.showModal();
  }

  function submitReport() {
    const reason = $('select[name="reason_type"]').val();

    if (!reason) {
      showAlert('warning', 'Please choose the reason type')
      return;
    }

    const formData = $('#reportForm').serialize();

    showAlert('warning', 'Send report...');
    $.ajax({
      url: "{{ route('ajax-send-report') }}",
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      data: formData,
      success: function(res) {
        if (res.status == 'success') {
          $('#reportForm')[0].reset();
          report.close();
          showAlert('success', res.message);
        } else {
          showAlert('error', res.message || 'Failed to send report');
        }
      }
    })
  }
</script>
