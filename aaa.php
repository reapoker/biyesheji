1. 如何优化sql查询 select id from user where phone='131' or phone='139'
答： 在sql查询中应当尽量避免使用or来连接where条件语句，会导致全表扫描，in 和not in也是
优化过后的语句： select id from user where phone='131'
union all
select id from user where phone='139'
然后在phone字段加上索引即可

2. 数据库表user只有id，name两个字段，编程实现删除重复数据，确保相同name的用户只保留一条数据
答： delete from
user
where name in (
select a.name from (
select name as name  user group by
name having count(name)>1
) a
)

3. 如果要求每天凌晨三点执行一次脚本run.php 如何实现？
答：两种方式：linux命令和php脚本方式
1. 使用linux中的crontab命令
2. 如果是虚拟主机(无法登陆命令行执行php程序):使用浏览器触发函数，然后使用ignore_user_abort()和set_time_limit(0)忽略用户离开的状态
然后获取系统时间，每隔一秒钟判断一次时间，在凌晨三点时，调用exec()函数执行 php run.php 命令，执行脚本
        <?php
        function exec_func()
        {
            ignore_user_abort();
            set_time_limit(0);
            while (true) {
                $time = date("His"); // 获取时间字符串
                if ($time == "30000") {
                    exec("php run.php");
                }
                sleep(1);
            }
        }

        ?>
3. 如果是服务器，则直接写一个脚本，放入while函数体即可：
        <?php
        while (true) {
            $time = date("His"); // 获取时间字符串
            if ($time == "30000") {
                exec("php run.php"); // 执行脚本
            }
            sleep(1);
        }
        ?>
4. 求一个整数数组中和最大的连续子数组，例如：[1,2,-4,4,10,-3,4,-5,1] 的最大连续子数组是[4,10,-3,4]（需写明思路，并编程实现）
答：DP问题，遍历数组并对连续数组元素做加法，因为是最大连续子数组，所以当出现负数时，和一定建校
        <?php
        $n = [];  // 要遍历的证书数组
        $total = trim(fgets(STDIN));  // 接收总数
        $num_str = trim(fgets(STDIN));
        $n = explode(' ', $num_str); // 以空格分割，获取该整数数组
        $sum = $n[0];  // 初始化临时和为数组的第一个数字
        $max = $n[0];  // 初始化最大和为数组的第一个数字
        $res = []; // 存放最大连续子数组
        foreach ($n as $v) {  // 开始遍历数组
            if ($sum >= 0) {  // 当前数字不小于0，则总和一定不会变小，所以直接加入
                $sum += $v;
            } else {    // 当前数字小于0，总和一定变小，所以从当前数字重新开始计算总和
                $sum = $v;
            }
            if ($sum > $max){  // 新和大于原本的最大和，将当前数字存入最终结果集
                $max = $sum;
                $res[] = $v;
            }else{    // 新和不大于最大和，清空结果集重新计算
                array_splice($res,0,count($res));
                $res[] = $v;  // 重新放入当前的数
            }
        }
        print_r($res);
        ?>

5. 请简述在PHP项目中遇到的最大的技术问题是什么，如何解决的
答： 写两个最近的吧...
    1. 使用php写的爬虫，爬取了大概50w条数据，使用laravel的分页功能，前后端分离开发，发现ajax的时间要超过40s，速度极慢
       解决办法：开启mysql的慢日志，针对日志中的数据，一条一条的进行优化，使用explain分析sql语句，对字段添加索引，
                放弃laravel中自带的分页功能（因为分页时获取总数的语句不会触发索引），自己用原生sql实现分页，把数据库查询时间从
                40s降低到不到1s

    2. 由于PHP-FPM的同步阻塞机制，导致传统PHP的性能始终受人诟病，而且laravel底层用到了大量的设计模式，依赖注入会使用大量反射，也会比较耗时，
       在测试并发的时候完全不能发挥出服务器该有的性能。
       解决办法：首先我尝试了引入Swoole，将Laravel移植到Swoole上，测试性能大概提高了20倍左右，但是Swoole无法使用传统php中的session，很难完美移植
                然后我试着不使用laravel，单独使用Swoole，发现性能提升了上百倍，所以我放弃了laravel框架，而是在Swoole基础上，重新写了一个小型框架，
                自己实现session等功能，针对laravel中的特性，很多symfony的包都可以实现，使用composer安装即可。