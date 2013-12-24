var vars = {};

$.views.tags({
    setvar: function(key, value) {
        globalspace[key] = value;
    }
});

$.views.helpers({
    getvar: function (key)
    {
        return globalspace[key];
    },
    formatDate: function (val)
    {
        return dateFormat(val);
    }
});

$.views.helpers({
    replaceLinks: function (inputText) {
        return identifyLinks(inputText);
    }
});
