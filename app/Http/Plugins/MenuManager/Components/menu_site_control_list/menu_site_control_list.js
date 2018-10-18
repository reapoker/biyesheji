define(function(){
    var handle = function(node,d){
        if(!Array.isArray(d.data)){
            var arr = [];
            for(var j in d.data){
                arr.push(d.data[j]);
            }
            var data = arr;
        }else{
            var data = d.data;
        }
        var ol = $("<ol></ol>").attr('class','dd-list'); //创建最外层ol
        for(var i=0;i<data.length;i++){
            var li = $("<li></li>");
            li.attr('class','dd-item');
            li.attr('data-order_id',data[i].order_id);
            li.attr('data-id',data[i].id);
            // li.attr('data-info',JSON.stringify(data[i]));
            var div = $("<div></div>");
            div.attr('class','dd-handle')
            var h = data[i].name+"|"+data[i].name_en + `<span class='pull-right' ><a onclick="setDetails(this,'${data[i].id}')" href="javascript:;">详细设置</a>   <a onclick="deleteMenu(this,'${data[i].id}')" href="javascript:;">删除</a></span>`;
            div.html(h);
            li.append(div); //把div加进去

            // 如果有二级，就放进去
            if(Array.isArray(data[i]['children'])){
                var dd = data[i]['children'];
                var ol2 = $("<ol></ol>");
                for(var j=0;j<dd.length;j++){
                    var li2 = $("<li></li>");
                    li2.attr('class','dd-item');
                    li2.attr('data-order_id',dd[j].order_id);
                    li2.attr('data-id',dd[j].id);
                    // li2.attr('data-info',JSON.stringify(dd[j]));
                    var div2 = $("<div></div>");
                    div2.attr('class','dd-handle')
                    var h2 = dd[j].name+"|"+dd[j].name_en + `<span class='pull-right' ><a onclick="setDetails(this,'${dd[j].id}')" href="javascript:;">详细设置</a>   <a onclick="deleteMenu(this,'${dd[j].id}')" href="javascript:;">删除</a></span>`;
                    div2.html(h2);

                    li2.append(div2);
                    ol2.append(li2);
                }
                li.append(ol2);
            }
            ol.append(li);
        }
        $("#site_control_menu").append(ol);
        $('#site_control_menu').nestable({
            group: 1
        })

        // $("#content_menu").html(html);
    }
    return {
        handle : handle
    }
})