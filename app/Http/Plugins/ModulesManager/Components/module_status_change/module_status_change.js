define(function(){
            var handle = function(node,d){
                layer.msg("操作成功！即将刷新页面",{icon:6},function(){
                    window.location.reload();
                })
            }
            return {
                handle : handle
            }
        })