<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php Yii::app()->bootstrap->register();?>
    <link rel="stylesheet" type="text/css" href="./public/css/login.css" />
    <title>登录管理中心</title>
</head>
<body>
<div id="header">
    <div class="logo"></div>
</div>
<div id="wrapper">
    <div class="console_left">
        <div class="title">欢迎使用悦视频视频管理系统</div>
        <p>
				<span>悦视频后台是采用PHP(mysql)和yii技术构建的一款专注于电视及移动互联网的视频管理系统！
				特别感谢开源软件（<a href="http://www.maccms.com" target="_blank" style="text-decoration:none;color:rgb(102, 102, 102);">苹果CMS</a>）开发者提供的辛勤工作。</span>

        </p>
        <div class="intro_1">轻松管理和配置各种信息</div>
        <div class="intro_2">轻松发布在线视频资源</div>
        <div class="intro_3">安全验证过滤无效信息</div>
    </div>
    <div class="console_right">
        <div class="title">请登录</div>
        <div class="login">
            <div class="form">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'login-check',
                    'htmlOptions'=>array('class'=>'well'),
                )); ?>
                <div class="user">
                    <label>用户名:</label><input tabindex="1" type="text" name="m_name"
                                              id="m_name" size="20" maxLength="20" value="">

                </div>
                <div class="pwd">
                    <label>密 码:</label><input tabindex="2" type="password"
                                              name="m_password" id="m_password" size="20" maxLength="20"
                                              value="">

                </div>
                <div class="code">
                    <label>安全码:</label><input tabindex="3" type="password"
                                              name="m_check" id="m_check" size="20" maxLength="20" value="">

                </div>

                <div class="btn_login">

                    <input type="submit" name="login" id="login" value="登陆" />
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="reg"></div>
    <hr class="hr_solid" />
</div>
<div id="footer">
		<span class="left">&copy;2012-2013 Powered by <a
                href="http://www.joyplus.tv" target="_blank">JoyPlus</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阅读joyplusCMS
			<a
                href="https://github.com/joyplus/joyplus-cms/wiki/joyplus%E6%9C%8D%E5%8A%A1%E5%88%97%E8%A1%A8"
                target="_blank"><font style="color: #00a1d9">《API文档》</font> </a> </span>
</div>
</body>