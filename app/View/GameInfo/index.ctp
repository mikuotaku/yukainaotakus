<?php
App::import('Vendor','util');
App::import('Vendor','platform');
?>


<!-- File: /app/View/Monsters/index.ctp -->
<style>

.alert {
	display: none;
	position: fixed;
	top: 50%;
	left: 50%;
	min-width: 300px;
	max-width: 600px;
	transform: translate(-50%,-50%);
	z-index: 99999;
	text-align: center;
	padding: 15px;
	border-radius: 3px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-info {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
}

.alert-warning {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

</style>


<script>
	// 当点击带有“data-ajax=link”的标签时，触发ajax事件
	$(function () {
		$("[data-ajax=link]").click(function () {
			var url = $(this).attr("href");
			var po=$(this)
			// 执行 ajax
			$.ajax({
				"url": url,
				"dataType": "json",
				"type": "get",
				"success": function (response) {
					if (response.result === true){
						//alert("收藏成功");
						$('.alert').html('收藏成功！').addClass('alert-success').show().delay(2000).fadeOut();
						po.html('♥');
					} else {
						//alert(response.msg);
						$('.alert').html(response.msg).addClass('alert-warning').show().delay(2000).fadeOut();
						po.html('♡');
                    }
				},
                "error": function(){
					//alert("通信失败");
					$('.alert').html('通信失败').addClass('alert-danger').show().delay(1500).fadeOut();
                }
			});
			return false;

		});
	})

	$(function(){
		// $(".wu").each(function(i){
		// 	i=i+1;
		// 	$(this).attr("src" , "img/gameInfo/game_img_"+i+"_1.jpg");
	 	// });

		$("[data-ajaxLike=link]").click(function(){
			var url = $(this).attr("href");
		$.ajax({
			"url":url,
			"dataType":"json",
			"type":"get",
			"success":function(response){
				if(response.result===true){
					$('.alert').html('操作成功！').addClass('alert-success').show().delay(2000).fadeOut();

				}else{
					$('.alert').html(response.msg).addClass('alert-success').show().delay(2000).fadeOut();

				}
			},
			"error": function(){
					alert("通信失败");
                }

		});
		return false;
	});
	})
	
	

		$(function(){
		$("[data-ajaxdontlike=link]").click(function(){
			var url = $(this).attr("href");
		$.ajax({
			"url":url,
			"dataType":"json",
			"type":"get",
			"success":function(response){
				if(response.result===true){
					alert("点踩成功");

				}else{
					alert(response.msg)
				}
			},
			"error": function(){
					alert("通信失败");
                }

		});
		return false;
	});
	})
</script>

    <div class="container">
	<h1>2019游戏最佳排行 <span style="color:red;"> *HOT</span></h1>
	<div class="alert"></div>


        <div class="row">
            <div class="col-lg-9">
		<?php 
		 foreach ($gameinfo as $GameInfo):
			//拿到id
			$gameid = $GameInfo['GameInfo']['id'];
		 ?>



                <div class="row">
                    <div class="col-3">


                        <?php
                        echo $this->Html->image("gameInfo/game_img_{$GameInfo['GameInfo']['id']}_1.jpg",[
                                'style'=>'max-height:240px;max-width:240px;'
                        ]);

                        echo $this->Html->link('上传图片', array(
                                'controller' => 'GameInfo',
                                'action' => 'uploadfile',
                                '?' => ['game_info_id' => $GameInfo['GameInfo']['id']]

                            ));

                        ?>


                        <br>

                        <?php
                        echo $this->Html->link('查看', array(
                                'action' => 'view',
                                $GameInfo['GameInfo']['id']
                            ));
                        ?>


                        <?php
                        echo $this->Html->link('编辑', array(
                                'action' => 'edit',
                                $GameInfo['GameInfo']['id']
                            ));
                        ?>


                        <?php
                        echo $this->Form->postLink('Delete', array(
                                'action' => 'delete',
                                $GameInfo['GameInfo']['id']
                            ), array('confirm' => 'Are you sure?'));
                        ?>

                        <br>

                    </div>
                    <div class="col-5">
                        游戏名字:<?php echo $GameInfo['GameInfo']['game_name']; ?><br>
                        <br>
                        游戏类型:<?php echo $GameInfo['GameInfo']['type']; ?><br>
                        <br>
                        发行时间:<?php echo $GameInfo['GameInfo']['release_date']; ?><br>
                        <br>
                        发行商:<?php echo $GameInfo['GameInfo']['publisher']; ?><br>
                        <br>
                        游戏平台:<?php
                        $decNum = $GameInfo['GameInfo']['platform'];
                        $platArray=(bin2dec($decNum)) ;
                        $myPlatform=showPlatform($platArray);
                        foreach ($myPlatform as $key => $value) {
                                echo $key." ";
                                    }
                                 ?><br>
                        <br>
                        评分:<?php echo $GameInfo['GameInfo']['score']; ?><br>

                    </div>

                    <div class="col-3">
                        <!-- 游戏价格: <?php echo $GameInfo['GameInfo']['price']; ?><br> -->

                        <br>

                        游戏介绍:<?php echo $GameInfo['GameInfo']['introduction']; ?><br>
                        <?php
                        if (in_array($GameInfo['GameInfo']['id'], $show)) {
                            $mark="♥";

                          }else{$mark="♡";}

                        echo $this->Html->link($mark, array(
                                'controller' => 'Collection',
                                'action' => 'ajaxCollection',
                                '?' => ['game_info_id' => $GameInfo['GameInfo']['id']],
                            ), [
                                'data-ajax' => 'link',
                                'style'=>'font-size:2em;color:red;text-decoration:none;'
                            ]

                        );


                        ?>
                    </div>


                    <div class="col-1">
                    <?php
                            // echo $this->Html->link('赞', array(
                            // 	'controller' => 'Likes',
                            // 	'action' => 'ajaxLike',
                            // 	'?' => ['game_info_id' => $GameInfo['GameInfo']['id']],
                            // ), [
                            // 	'data-ajaxLike' => 'link'
                            // ]

                        //);
                        echo $this->Html->link(
                            $this->Html->image("good.png",['width' => '60',
                                'height' => '60']),
                                // "<img src='/img/iine.png' >",
                            array(
                            'controller'=>'Likes',
                            'action'=>'ajaxLike',
                            '?' => ['game_info_id' => $GameInfo['GameInfo']['id'],'like'=>1],

                        ), [
                            'data-ajaxLike' => 'link',
                            'escape' => false
                        ]

                        );

                    echo isset($uplike[$gameid])?$uplike[$gameid]:0;
                        //debug($uplike);

                        ?>


    <br>
    <br>
    <?php

                        echo $this->Html->link(
                            $this->Html->image("bad.png",['width' => '60',
                                'height' => '60']),
                                // "<img src='/img/iine.png' >",
                            array(
                            'controller'=>'Likes',
                            'action'=>'ajaxLike',
                            '?' => ['game_info_id' => $GameInfo['GameInfo']['id'],'like'=>-1],
                        ), [
                            'data-ajaxLike' => 'link',
                            'escape' => false
                        ]
                        );

                        echo isset($dislike[$gameid])?$dislike[$gameid]:0;

                    ?>

                    </div>
                </div>


             <hr>
		<?php endforeach; ?>
            </div>
            <div class="col-lg-3">
                <form>

                <h2>按照时间查找</h2>
                <h3>已选择条件</h3>
                <hr>
                <h3>发售时间</h3>
                <hr>
                <h3>游戏平台</h3>
                <hr>
                <h3>游戏语言</h3>
                <hr>
                <h3>游戏类型</h3>
                <hr>

                </form>

            </div>
        </div>
<?php

$pageBegin = $pagenation['pageBegin'];
$pageEnd = $pagenation['pageEnd'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;

echo '<nav aria-label="...">';
echo   '<ul class="pagination">';
echo     '<li class="page-item disabled">';
       
echo     "</li>";
		$disabled=$page==1?'disabled':'';
echo     "<li class=\"page-item {$disabled}\">";
echo '<a class=\'page-link\' href="?page=' . ($page - 1) . '">上一页</a></li>';


for ($a = $pageBegin; $a <= $pageEnd; $a++) {
	$activeClass = $a == $page ? 'active' : '';
	echo "<li class=\"page-item {$activeClass}\">
	<a class='page-link' href=\"?page={$a}\">{$a}</a ></li>";


// debug($page);
//  debug($a);	
}

echo '<span class="sr-only">(current)</span>';
$disabledlast=$page==$pageEnd?'disabled':'';
echo     "<li class=\"page-item {$disabledlast}\">";
			
echo       '<a class=\'page-link\' href="?page=' . ($page + 1) . '">下一页</a>';
echo     "</li>";
echo   "</ul>";
echo 		"</nav>";


?>
