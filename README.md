# dnmp
docker上一键部署lnmp。具体步骤可到[我的简书](https://www.jianshu.com/p/d04e00d0bf8d)查看
Docker deploying Nginx MySQL PHP7 in one key, support full feature functions.

## [](https://github.com/shmilylbelva/dnmp#1-feature)1\. Feature

1.  完全开源
    Completely open source.
2.  支持多版本PHP切换（PHP5.4、PHP5.6、PHP7.2...)
    Support Multiple PHP version(PHP5.4, PHP5.6, PHP7.2) switch.
3.  支持绑定任意多个域名
     Support Multiple domains.
4.  支持HTTPS和HTTP/2
    Support HTTPS and HTTP/2.
5.  PHP源代码位于宿主机中
    PHP source located in host.
6.  MySQL data位于宿主机中
    MySQL data directory in host.
7.  所有配置文件可在宿主机中直接修改
    All conf files located in host.
8.  所有日志文件可在宿主机中直接查看
    All log files located in host.
9.  内置完整PHP扩展安装命令
    Built-in PHP extensions install commands.
10. 实现一次配置，Windows、Linux、MacOs皆可用
    Supported any OS with docker.

## [](https://github.com/shmilylbelva/dnmp#2-usage)2\. Usage

1.  Install `git`, `docker` and `docker-compose`;
2.  Clone project:$ git clone https://github.com/shmilylbelva/dnmp.git
3.  Start docker containers:You may need use `sudo` before this command in Linux.
4.  Go to your browser and type `localhost`, you will see:
![image.png](https://upload-images.jianshu.io/upload_images/2825702-5734fb2e9c16a625.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

The index file is located in `./www/site1/`.

## [](https://github.com/shmilylbelva/dnmp#3-other-php-version)3\. Other PHP version?

Default, we start LATEST PHP version by using:

we can also start PHP5.4 or PHP5.6 by using:

We need not change any other files, such as nginx config file or php.ini, everything will work fine in current environment (except code compatibility error).

> Notice: We can only start one php version, for they using same port. We must STOP the running project then START the other one.

## [](https://github.com/shmilylbelva/dnmp#4-https-and-http2)4\. HTTPS and HTTP/2

Default demo include 2 sites:

*   [http://www.site1.com](http://www.site1.com/) (same with [http://localhost](http://localhost/))
*   [https://www.site2.com](https://www.site2.com/)

To preview them, add 2 lines to your hosts file (at `/etc/hosts` on Linux and `C:\Windows\System32\drivers\etc\hosts` on Windows):

Then you can visit from browser.

## [](https://github.com/yeszao/dnmp#5-use-log)5\. Use log

We can identify log directory in nginx / php / php-fpm / mysql config file. To display the log file in host

## [](https://github.com/yeszao/dnmp#6-license)6\. License

MIT