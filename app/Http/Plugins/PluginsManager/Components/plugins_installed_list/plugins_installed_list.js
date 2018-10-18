define(['jquery'],function($){
            var handle = function(node,d){
                var data = d.data;
                var html = '';
                if(data==null) return false;
                for(var i=0;i<data.length;i++){
                    html += `
                    <tr class="">
                      <td width="10"><input type="checkbox"> </td>
                      <td> ${data[i].id} </td>
                      <td> ${data[i].name} </td>
                      <td> ${data[i].dir} </td>
                      <td> ${data[i].description} </td>
                      <td> 
                         <div class="btn-group">
                              <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 更多操作
                                 <i class="fa fa-angle-down"></i>
                              </button>
                              <ul class="dropdown-menu pull-left" role="menu">
                                <li>
                                     <a  href="/Admin/p.${data[i].dir}.index">
                                     <i class="icon-docs"></i> 设置 </a>
                                 </li>
                                 <li>
                                     <a onclick="delete_plugin(this,'plugin_delete','${data[i].dir}')" href="javascript:;">
                                     <i class="icon-docs"></i> 卸载 </a>
                                 </li>
                              </ul>
                             </div> 
                       </td>
                    </tr>
                    `;
                }

                $("#installedList").html(html);
            }
            return {
                handle : handle
            }
        })