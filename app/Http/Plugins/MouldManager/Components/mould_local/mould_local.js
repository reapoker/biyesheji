define(['text!/templates/mould_list.tpl','art'],function(text,art){
            var handle = function(node,d){
                console.log(d);
                $(node).html(art.render(text,d));
            }
            return {
                handle : handle
            }
        })