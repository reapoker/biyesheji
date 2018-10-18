define(['jquery'],function (){

    var handle = function (node,d){
        var data = d.data;
        var html = '';
        for(var i=0;i<data.length;i++){
            html += `
                         <tr class="">
                           <td width="10"><input type="checkbox"> </td>
                           <td> ${data[i].name} </td>
                           <td> ${data[i].description} </td>
                           <td> ${data[i].belongTo} </td>
                           <td> ${data[i].type} </td>
                           <td> ${data[i].status} </td>
                           <td>
                             <div class="btn-group">
                              <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 更多操作
                                 <i class="fa fa-angle-down"></i>
                              </button>
                              <ul class="dropdown-menu pull-left" role="menu">
                                <li>
                                     <a name="${data[i].name}" onclick="comp_modify(this)" model_name="${data[i].belongTo}" href="javascript:;">
                                     <i class="icon-docs"></i> 修改 </a>
                                 </li>
                                 <li>
                                     <a name="disabled" href="javascript:;">
                                     <i class="icon-docs"></i> 禁用 </a>
                                 </li>
                                 <li>
                                     <a onclick="delete_c(this,'component_delete','${data[i].name}')" name="delete" href="javascript:;">
                                     <i class="icon-docs"></i> 删除 </a>
                                 </li>
                              </ul>
                             </div>
                            </td>
                        </tr>
                `;
        }
        $("#components").html(html);

    };

    return {

        handle: handle
    };

});