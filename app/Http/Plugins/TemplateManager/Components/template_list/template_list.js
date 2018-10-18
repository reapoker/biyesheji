define(function(){
    var handle = function(node,d){
        var data = d.data;
        var html = '';
        for(var i=0;i<data.length;i++){
            html +=`
                   <tr class="">
                       <td width="10"><input type="checkbox"></td>
                       <td> ${data[i].name}</td>
                       <td>
                        <button onclick="temp_modify(this)" name="${data[i].name}" class="btn btn-success">修改</button>
                        <button onclick="delete_t(this,'template_delete','${data[i].name}')" class="btn btn-danger">删除</button>
                       </td>
                    </tr>
                   `;
        }
        $(node).html(html);
    }
    return {
        handle : handle
    }
})