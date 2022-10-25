## BTL Craft官网

[![License](https://img.shields.io/github/license/Rene8028/carpet-iee-addition.svg)](https://www.gnu.org/licenses/quick-guide-gplv3.html)
![](https://img.shields.io/badge/V-ME-red)
![](https://img.shields.io/badge/WE%20ARE-POOR-yellow)

如果你需要使用此项目，请前往release下载或手动构建，并在相关文件中改成自己的服务器名称。以后可能会做一个安装界面（咕~）。

## 如何使用？

### 检查你的机器是否符合安装需求

#### 基本要求

和 blessing skin 一样，流畅运行此网站对你的服务器的配置的要求非常低（除非你加了一堆东西）。你需要检查的是你的运行环境。

此网站只支持 Nginx 或 Apache 作为 Web 服务器，不支持 IIS。PHP 版本必须为 8.0.2 或以上。

由于自检还没投入使用，判断环境安装正确的方法是：如果安装正确，网站的每一处都不应该有报错。

如果你曾经正确运行过blessing skin，那么你可以直接像原来那样配置。

#### 必需的 PHP 扩展

请确保这些扩展已经安装并开启：

- OpenSSL >= 1.1.1 (TLS 1.3)
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- fileinfo
- zip

#### 必须开启的函数


请不要在`php.ini`中禁用任何函数！

#### 其它

由于自检还没投入使用，判断环境安装正确的方法是：如果安装正确，网站的每一处都不应该有报错。

> **建议**
> 
> 除非有特别需要，我们不建议使用 Windows 作为服务器的操作系统。使用 Windows 不仅会影响皮肤站的运行效率，还有可能会产生一些不会在 Linux 上出现的奇怪问题。

> **针对使用宝塔面板的用户**
> 
> 如果您在使用宝塔面板，请取消所有被禁用的函数（若安装有多个 PHP，需要对所有的版本进行同样的操作），并关闭防跨站安全设置。
> 
> 当然，我们建议您最好不要使用此类面板软件。

## 手动构建（不推荐）

确保你已经安装 composer ，然后将所有源代码拉取下来，运行built.bat
  
## 使用早期版本

以前的版本都在.old文件夹下，直接下载下来并解压即可
