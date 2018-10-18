define(['jquery'],function($){
            var handle = function(node,d){
                var data = d.data;
                var html = '';
                if(data==null) return false;
                for(var i=0;i<data.length;i++){
                    html +=`
                     <tr class="">
                          <td><input type="checkbox"> </td>
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
                                     <a dir="${data[i].dir}" onclick="plugin_install(this)" href="javascript:;">
                                     <i class="icon-docs"></i> 安装 </a>
                                 </li>
     
                                 <li>
                                     <a onclick="delete_plugin(this,'plugin_delete','${data[i].dir}')" href="javascript:;">
                                     <i class="icon-docs"></i> 删除 </a>
                                 </li>
                              </ul>
                             </div> </td>
                     </tr>
                    `;
                }
                $("#all_plugins").html(html);
            }
            return {
                handle : handle
            }
        })