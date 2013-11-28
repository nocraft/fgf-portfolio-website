		  <form role="form" action="<?php echo Router::url('admin/posts/edit/'.$id); ?>" method="post">
			<?php echo $this->Form->input('name','Titre'); ?>
			<?php echo $this->Form->input('slug','Url'); ?>
			<?php echo $this->Form->input('category_id','Catégorie',array('options' => $categories,'typecat' => 'post')); ?>
			<?php echo $this->Form->input('created','Date de création',array('class'=>'datepicker')); ?>
			<?php echo $this->Form->input('id','hidden'); ?>
			<?php echo $this->Form->input('content','Contenu',array('type'=>'textarea','class'=>'xxlarge wysiwyg','rows'=>5)); ?>
			<div class="checkbox">
				<label>
					<?php echo $this->Form->input('online','En ligne',array('type'=>'checkbox')); ?>
				</label>
			</div>
			<div class="actions">
				<input type="submit" class="btn btn-primary" value="Envoyer">
			</div>
		</form>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo Router::webroot('js/tinymce/tiny_mce.js'); ?>"></script>
		
<script type="text/javascript">
		
      tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "wysiwyg",
        theme : "advanced",
        relative_urls : false,
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",
        file_browser_callback : 'fileBrowser'
    });

    function fileBrowser(field_name, url, type, win){
      if(type=='file'){
          var explorer = '<?php echo Router::url('admin/posts/tinymce'); ?>';
      }else{
          var explorer = '<?php echo Router::url('admin/medias/index/'.$id); ?>';
      }
      tinyMCE.activeEditor.windowManager.open({
        file : explorer,
        title : 'Gallerie',
        width: 420,
        height: 400,
        resizable : 'yes',
        inline : 'yes',
        close_previous : 'no'
      },{
        window : win,
        input : field_name
      });
      return false; 
    }
</script>