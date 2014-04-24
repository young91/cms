<?php
/* @var $this LoginController */

$this->breadcrumbs=array(
	'Login',
);
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <?php Yii::app()->bootstrap->register(); ?>
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
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-check',
                    'enableAjaxValidation'=>true,
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
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'type'=>'primary',
                    'label'=>'Click me',
                    'loadingText'=>'loading...',
                    'htmlOptions'=>array('id'=>'buttonStateful'),
                )); ?>
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
</div>
<div id="footer">
		<span class="left">&copy;2012-2013 Powered by <a
                href="http://www.joyplus.tv" target="_blank">JoyPlus</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阅读joyplusCMS
			<a
                href="https://github.com/joyplus/joyplus-cms/wiki/joyplus%E6%9C%8D%E5%8A%A1%E5%88%97%E8%A1%A8"
                target="_blank"><font style="color: #00a1d9">《API文档》</font> </a> </span>
</div>
<script>
    var cururl=",<?php echo geturl();?>";
    $(document).ready(function(){
        $("#login").click(
            function(){
                if($('#m_name').val() == ""){
                    alert( "请输入用户名" );
                    $('#m_name').focus();
                    return false;
                }
                if($('#m_password').val() == ""){
                    alert( "请输入密码" );
                    $('#m_password').focus();
                    return false;
                }
                if($('#m_check').val() == ""){
                    alert( "请输入安全码" );
                    $('#m_check').focus();
                    return false;
                }
                $("#form1").submit();
                $("#login").attr("disabled", "disabled");
            }
        );
        $('#m_name').focus();
        $("img").pngfix();
        if(cururl.indexOf("/admin/") >0){alert('请将文件夹admin改名,避免被黑客入侵攻击');}
    });
</script>

</body>
</html>
