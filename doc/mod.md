<br><br>

# 配置 Mod

Blessing skin皮肤站仅提供材质的上传、存储、检索和分享的功能。想要在 Minecraft 中显示你在皮肤站设置的材质的话，你需要在 Minecraft 客户端中安装皮肤 Mod 并修改相应的配置文件。

> 提示：
> 
> 如何安装 Mod 请自行搜索，本文不会说明如何安装皮肤 Mod，仅说明如何配置皮肤 Mod，使其从 LittleSkin 加载材质。
>
>在一些情况下，安装皮肤 Mod 后，可能需要启动一次游戏并进入存档，Mod 才会自动生成配置文件；如果你在启动器中启用了版本隔离，配置文件的路径可能有所不同。

<div class="red-box">
    <p><strong>警告：</strong></p>
    <p>只需要使用一种皮肤 Mod 即可。请不要同时安装多个皮肤 Mod，否则，轻则无法正常加载材质，重则导致游戏崩溃。</p>
</div>

<div class="yellow-box">
    <p><strong>警告：</strong><p>
    <p>除 SkinPort 外，皮肤 Mod 和 Yggdrasil 外置登录二选一即可。请不要同时使用这两者，否则可能无法正常加载材质。</p>
</div>

## CustomSkinLoader

CustomSkinLoader 是一个皮肤补丁mod   
你可以在[MCBBS](https://www.mcbbs.net/thread-269807-1-1.html)或[Curseforge](https://www.curseforge.com/minecraft/mc-mods/customskinloader)获取关于 CustomSkinLoader 的更多信息。

CustomSkinLoader 14.4 起支持通过 ExtraList 的方式添加皮肤站，这也是我们推荐的方法之一。你可以在用户中心的「配置生成」页面下载到皮肤站的 ExtraList 文件，将其放入 ```.minecraft/CustomSkinLoader/ExtraList/``` 目录下即可。

在安装完成后的第一次启动游戏并成功载入 CustomSkinLoader 时 ExtraList 文件会被自动删除，这是正常现象。如果不出意外的话，此时皮肤站已被添加至 CustomSkinLoader 加载列表列表顶部。
