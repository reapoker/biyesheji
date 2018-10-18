define(['text!/templates/role_list.tpl','art'],function(text,art){
            var handle = function(node,d){
                var temp = art.compile(text);
                var html = temp(d);
                $(node).html(html);
            }
            return {
                handle : handle
            }
        })