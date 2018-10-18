define(function(){
            var handle = function(node,d){
                $(node).html(d.data.fullname);
            }
            return {
                handle : handle
            }
        })