define(['text!/templates/module_list.tpl','art'],function (text,art) {
    var handle = function (node, d) {
        var data = d.data;
        console.log(data);
       $(node).html(art.render(text,d));

    }
    return {
        handle: handle
    }
})