资源文件目录

2015-3-5
so_company表添加
control_busin_license    是否有营业执照
control_code_certificate 是否有机构代码证
control_certificate      是否有资质证明
3个字段

2015-3-10
so_comment表添加
childs                   未审核的回复数量

2015-3-16
so_company
select_time

2015-3-18
so_inexposal
add validate_time

2015-3-24
so_comment表添加
pparent_id 祖父id 默认为0

2015-3-30
so_comment表添加
has_child 审核通过的回复数量

2015-4-2
so_com_exposal表添加
is_anonymous 是否匿名(0-不匿名,-1-匿名)

2015-4-8
so_com_exposal表添加
pic_1 图片id
pic_2 图片id
pic_3 图片id
pic_4 图片id
pic_5 图片id
type 评论类型
top_num 顶总数
has_child 审核通过的回复数量
添加so_com_exposal_top表

2015-4-10
so_com_exposal表添加
childs 未审核的回复数量

2015-4-14
so_attention表添加

2015-4-28
so_comment表添加
last_child_time 最新回复评论时间
last_cchild_time 最新再回复评论时间
last_time 最新操作时间
so_com_exposal表添加
last_child_time 最新回复时间
last_time 最新操作时间
添加so_share_count分享计数表

2015-4-29
so_inexposal表添加
auth_level企业等级字段
