<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    
    <title>编辑节点</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    

<link rel="stylesheet" type="text/css" href="__ASSETS__/charisma/css/bootstrap-cerulean.css" />


<link rel="stylesheet" type="text/css" href="__ASSETS__/jquery-ui-bootstrap/css/jquery-ui-1.10.0.custom.css" />


<link rel="stylesheet" type="text/css" href="__ASSETS__/charisma/css/charisma-app.css" />


<link rel="stylesheet" type="text/css" href="__ASSETS__/charisma/css/chosen.css" />
<link rel="stylesheet" type="text/css" href="__ASSETS__/charisma/css/uniform.default.css" />
<link rel="stylesheet" type="text/css" href="__ASSETS__/charisma/css/opa-icons.css" />
<link rel="stylesheet" type="text/css" href="__ASSETS__/plugins/bwizard/bwizard.css" />


<link rel="stylesheet" type="text/css" href="__ASSETS__/css/custom.css" />
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script type="text/javascript" src="__ASSETS__/js/jquery-1.8.3.min.js"></script>
</head>
<body>



<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand"> <img alt="Logo" src="__ASSETS__/charisma/img/logo20.png" /> <span>超市管理系统</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right" >
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-user"></i><span class="hidden-phone">用户组：用户名</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a >修改个人资料</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo U('/index/logout');?>">退出登陆</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->


            <!--
            <div class="top-nav nav-collapse">
                <ul class="nav">
                    <li>
                        <form class="navbar-search pull-left">
                            <input placeholder="Search" class="search-query span2" name="query" type="text">
                        </form>
                    </li>
                </ul>
            </div>
            -->
            <!--/.nav-collapse -->
        </div>
    </div>
</div>




<div class="well nav-collapse sidebar-nav affix span2">
    <ul class="nav nav-tabs nav-stacked main-menu">
        <li class="nav-header hidden-tablet">功能列表</li>
        <li>
            <a href="<?php echo U('/index');?>">
                <i class="icon-home"></i>
                <span class="hidden-tablet">仪表盘</span>
            </a>
        </li>
        <li>
            <a href="#authority" class="nav-header menu-first collapsed" data-toggle="collapse">
                <i class="icon-lock"></i>权限管理</a>
            <ul id="authority" class="nav nav-list collapse in menu-second">
                <li><a href="<?php echo U('node/index');?>"><i class="icon-list"></i>节点列表</a></li>
                <li><a href="<?php echo U('role/index');?>"><i class="icon-list"></i>角色列表</a></li>
                <li><a href="<?php echo U('staff/index');?>"><i class="icon-list"></i>员工列表</a></li>
                <li><a href="<?php echo U('node/add');?>"><i class="icon-user"></i>增加节点</a></li>
                <li><a href="<?php echo U('staff/add');?>"><i class="icon-user"></i>新增员工</a></li>
            </ul>
        </li>
    </ul>
</div>

<div class="container">
    <div class="row">

        <div class="span11 offset1" style="min-height: 500px;">
            
            <!--
            <ul class="breadcrumb">
            
                <li>
                    <a href="<?php echo U('/index');?>">后台首页</a>
                    <span class="divider">/</span>
                </li>
            
            </ul>
            -->

            
            

    <div class="box">
        <div class="box-header well-small">
            <h4><i class="icon-edit"></i>编辑节点</h4>
        </div>
        <div class="box-content">

            <form class="form-horizontal" method="post" action="<?php echo U('node/update');?>">
                <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>" />
                <fieldset>
                    <legend>节点信息<a class="btn btn-info pull-right" href="<?php echo U('node/index');?>">返回节点列表</a></legend>
                    <div class="control-group">
                        <label class="control-label">名称：</label>
                        <div class="controls">
                            <input type="text" name="name"  value="<?php echo ($vo["name"]); ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">显示名：</label>
                        <div class="controls">
                            <input type="text" name="title" value="<?php echo ($vo["title"]); ?>"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">状态：</label>
                        <div class="controls">
                            <select name="status">
                                <option value="1" selected="selected">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">类型：</label>
                        <div class="controls">
                            <select name="level">
                                <option value="1" selected="selected">项目</option>
                                <option value="2">模块</option>
                                <option value="3">操作</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">父级组ID：</label>
                        <div class="controls">
                            <select id=""  name="pid" class="" > <option value="0" level="-1">根节点</option><option value="1"  level="1" >SuperMarket(超市管理系统)</option><option value="2"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Staff(员工管理)</option><option value="3"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Node(节点管理)</option><option value="4"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Role(角色管理)</option><option value="5"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Branch(分店管理)</option><option value="6"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Supplier(供货商管理)</option><option value="7"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Category(商品分类管理)</option><option value="8"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ Goods(商品信息管理)</option><option value="9"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;├ StockRecord(商品入库管理)</option><option value="10"  level="1" >&nbsp;&nbsp;&nbsp;&nbsp;├ SalesRecord(商品销售管理)</option><option value="11"  level="2" >&nbsp;&nbsp;&nbsp;&nbsp;└ Member(超市会员管理)</option></select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">显示排序：</label>
                        <div class="controls">
                            <input type="text" name="sort" value="<?php echo ($vo["sort"]); ?>"/>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">描述：</label>
                        <div class="controls">
                            <textarea  name="remark" class="autogrow" ><?php echo ($vo["remark"]); ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">确定</button>
                        <button type="reset" class="btn">取消</button>
                    </div>
                </fieldset>
            </form>

        </div>
    </div>


        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <hr/>
        <div class="span12">
            <span class="label label-info offset4"><a href="http://supermarket.f-tm.net">超市管理系统</a> @GoogleRobot 版权所有  </span>
        </div>
    </div>
</div>




<script type="text/javascript" src="__ASSETS__/bootstrap/js/bootstrap.js"></script>


<script type="text/javascript" src="__ASSETS__/jquery-ui-bootstrap/jquery-ui-1.9.2.custom.min.js"></script>


<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.chosen.min.js"></script>


<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.flot.min.js"></script>
<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.flot.stack.js"></script>


<script type="text/javascript" src="__ASSETS__/charisma/js/jquery.uniform.min.js"></script>


<script type="text/javascript" src="__ASSETS__/charisma/js/charisma.js"></script>


<script type="text/javascript" src="__ASSETS__/plugins/jquery-form/jquery.form.js"></script>


<script type="text/javascript" src="__ASSETS__/plugins/bwizard/bwizard.js"></script>


<script type="text/javascript" src="__ASSETS__/js/custom.js"></script>



</body>
</html>