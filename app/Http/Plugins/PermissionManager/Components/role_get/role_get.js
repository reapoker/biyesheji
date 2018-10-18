define(['text!/templates/role_modify.tpl','art'],function(text,art){
            var handle = function(node,d){
                var html = art.render(text,d.data);
                $(node).html(html);
            }
            return {
                handle : handle
            }
        })