define(['text!/templates/themes_list.tpl','art'],function(text,art){
            var handle = function(node,d){
                $(node).html(art.render(text,d))
            }
            return {
                handle : handle
            }
        })