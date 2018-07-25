create database if not exists `shopImooc`;

use `shopImooc`;

-- 创建管理员表
drop table if exists `imooc_admin`;
create table `imooc_admin`(
`id` tinyint unsigned auto_increment key,
`username` varchar(20) not null unique comment '账号',
`password` char(32) not null comment '密码',
`email` varchar(50) not null comment '邮箱'
);

-- 分类表
drop table if exists `imooc_cate`;
create table `imooc_cate`(
`id` smallint unsigned auto_increment key,
`cName` varchar(50) unique comment '分类名'
);

-- 商品表
drop table if exists `imooc_pro`;
create table `imooc_pro`(
`id` int unsigned auto_increment key,
`pName` varchar(50) not null unique comment '商品名',
`pSn` varchar(50) not null comment '商品货号',
`pNum` int unsigned default 1 comment '商品数量',
`mPrice` decimal(10,2) not null comment '商品价格',
`iPrice` decimal(10,2) not null,
`pDesc` text comment '商品描述',
`pImg` varchar(50) not null comment '商品图片',
`pubTime` int unsigned not null comment '发布时间',
`isShow` tinyint(1) default 1 comment '1 发布 0 下架',
`isHot` tinyint(1) default 0 comment '1 热卖 0 非热卖',
`cId` smallint unsigned not null comment '所属分类Id'
);

-- 用户表
drop table if exists `imooc_user`;
create table `imooc_user`(
`id` int unsigned auto_increment key,
`username` varchar(20) not null unique comment '账号',
`password` char(32) not null comment '密码',
`sex` enum('男','女','保密') not null default '保密' comment '性别',
`face` varchar(50) not null comment '头像',
`regTime` int unsigned not null comment '注册时间'
);

-- 相册表
drop table if exists `imooc_album`;
create table `imooc_album`(
`id` int unsigned auto_increment key,
`pid` int unsigned not null comment '商品id',
`albumPath` varchar(50) not null comment '图片路径'
);