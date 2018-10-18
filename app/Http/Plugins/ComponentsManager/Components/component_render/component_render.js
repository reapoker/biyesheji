define(function(){
            var handle = function(node,d){
				window.location.reload();
				layer.msg('重新渲染成功！', {icon: 6,offset:'100px;'});
            }
            return {
                handle : handle
            }
        })