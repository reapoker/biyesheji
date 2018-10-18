define(function(){
            var handle = function(node,d){
                console.log(d);
                var data = d.data;
                var html = '';
                for(var i=0;i<data.length;i++){
                    html += `
                    <option value="${data[i].id}">${data[i].name}|${data[i].name_en}</option>
                    `;
                }
                $("#parent_menu").append(html);
            }
            return {
                handle : handle
            }
        })