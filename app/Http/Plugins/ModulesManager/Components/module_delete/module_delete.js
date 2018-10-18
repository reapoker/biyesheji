define(function(){
            var handle = function(node,d){
                layer.msg("删除成功！即将刷新页面!",{icon:6,offset:'150px'},function () {
                    window.location.reload();
                })
            }
            return {
                handle : handle
            }
        })