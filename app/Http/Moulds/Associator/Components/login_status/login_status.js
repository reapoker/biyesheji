define(['jquery'],function ($) {
    var handle = function (node, d) {
        if(d.info=='Successed!'){
            var name = d.data[0].name;
            var html = `
             <a href="dl.html">
                        ${name}
                    </a>
                    <a href="">
                        购物车
                    </a>
                    <a href="">
                        网站地图
                    </a>
            `;

            $(node).html(html);
            $(node).show();
        }
    }
    return {
        handle: handle
    }
})