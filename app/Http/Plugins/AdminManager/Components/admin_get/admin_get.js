define(['text!/templates/admin_modify.tpl','art'],function(text,art){
            var handle = function(node,d){
                var html = art.render(text,d.data);
                console.log(html);
                 $(node).html(art.render(text,d.data));
            }
            return {
                handle : handle
            }
        })