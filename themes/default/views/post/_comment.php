<?php 
	$young91CommentModel = new PostComment();
	$young91CommentCriteria = new CDbCriteria();
	$young91CommentCriteria->condition = 'post_id='.$young91Show['id'];
	$young91CommentCriteria->order = 't.id DESC';
	$young91CommentCount = $young91CommentModel->count( $young91CommentCriteria );
	$young91CommentPages = new CPagination( $young91CommentCount );
	$young91CommentPages->pageSize = 15;
	$young91CommentPageParams = XUtils::buildCondition( $_GET, array ( 'id'    ) );
	$young91CommentPageParams['#'] = 'commentList';
	$young91CommentPages->params = is_array( $young91CommentPageParams ) ? $young91CommentPageParams : array ();
	$young91CommentCriteria->limit = $young91CommentPages->pageSize;
	$young91CommentCriteria->offset = $young91CommentPages->currentPage * $young91CommentPages->pageSize;
	$young91CommentList = $young91CommentModel->findAll( $young91CommentCriteria );
?>
<div id="comment">
      <div class="boxTit ">
        <h3>最新评论</h3>
      </div>
      <div class="bmc">
      <?php foreach($young91CommentList  as $key=>$row):?>
        <dl class="item clear">
          <dt class="user"> <a class="title" ><?php echo $row->nickname?></a> <span class=" xw0"><?php echo date('Y-m-d H:i:s',$row['create_time'])?></span> </dt>
          <dd class="con"><?php echo CHtml::encode($row['content'])?></dd>
        </dl>
         <?php endforeach?>
         <div class="pagebar clear">
          <?php $this->widget('CLinkPager',array('pages'=>$young91Pagebar));?>
        </div>
        <form id="commentForm" name="cform"  method="post" autocomplete="off">
          <div class="cForm">
            <div class="area">
              <textarea name="comment" rows="3" class="pt validate[required]" id="comment" ></textarea>
            </div>
           
          </div>
          <div> 昵称：<input name="nickname" type="text" id="nickname" class="validate[required]"/> 邮箱：<input name="email" type="text" id="email" class="validate[required]"/></div>
          <p class="ptn">
           <input type="hidden" name="postId" id="postId" value="<?php echo $young91Show['id']?>" />
            <button class="button" type="button" id="postComment">提交</button>
          </p>
          <div id="errorHtml"></div>
        </form>
      </div>
    </div>
<script type="text/javascript">
$("#postComment").click(
	function(){
		$.post("<?php echo $this->createUrl('post/postComment')?>",$("#commentForm").serializeArray(),function(res){
			if(res.state == 'success'){
				window.location.reload();
      }else{
        $("#errorHtml").html(res.message).show();
      }
	},'json');	
	}
);
</script>