import Tagify from "@yaireo/tagify";
import "@yaireo/tagify/dist/tagify.css";

const tagEl = document.getElementById("tags");

const tagify = new Tagify(tagEl, {
    whitelist: [],
    dropdown: {
        maxItems: 10,
        enabled: 1,
        closeOnSelect: false,
    },
    maxTags: 10,
});


$.ajax({
    url: '/ajax/get-whitelist-tagify',
    type: 'get',
    success: function (res) {
        tagify.settings.whitelist = res;
    }
})