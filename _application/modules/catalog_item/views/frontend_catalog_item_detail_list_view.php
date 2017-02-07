
<div class="panel-body"></div>
<h3><?php
    if (!empty($catalog_item_detail)) {
        echo $catalog_item_detail->catalog_item_title;
    } else {
        echo "";
    }
    ?>
</h3>

<section>
    <div id="mybook">
        <?php
        if (!empty($query)) {
            foreach ($query as $row) {

                if (!empty($row->catalog_item_detail_image)) {
                    $image = '<img src="' . base_url() . _dir_catalog_item_detail . $row->catalog_item_detail_image . '" rel="prettyPhoto[gallery01]" class="img-zoom img-responsive">';
                } else
                    $image = '';
                echo'<div>';
                echo'<a href="' . base_url() . _dir_catalog_item_detail . $row->catalog_item_detail_image . '" rel="prettyPhoto[gallery01]" title="" class="thumbnail">' . $image . '</a>';
                //echo'<a href="' . $image . '" rel="prettyPhoto[gallery01]" title="' . $row->gallery_item_title . '" class="thumbnail">"' . $image . '"</a>';
                //echo $image;
                echo'</div>';
                
            }
        } else {
            echo '<div class = "alert alert-danger" role = "alert">
                <span class = "glyphicon glyphicon-exclamation-sign" aria-hidden = "true"></span>
                <span class = "sr-only">Error:</span>
                Mohon Maaf, Catalog Belum Tersedia
                </div>';
        }
        ?>

    </div>
</section>
<!--<div class="pagination">-->
<?php //echo $pagination;  ?>
<!--</div>-->
<br>
<br>
Download versi pdf <a href="<?php echo base_url(); ?>catalog_item/download">disini </a>

<script type="text/javascript">
		$(function () {
			// Init
			
			var updateSelect = function (event, data) {
				var pageTotal = data.options.pageTotal;
				$('#gotoIndex, #addIndex, #removeIndex').children().remove();
				$('#gotoIndex, #addIndex, #removeIndex').append('<option value="start">start</option><option value="end">end</option>');						
				for(i = 0; i < pageTotal; i++) {
					$('#gotoIndex, #addIndex, #removeIndex').append('<option value="'+ i +'">'+ i +'</option>');						
				}
			};
			
			var options = $.extend({}, $.fn.booklet.defaults, {
				pagePadding: 15,
				menu: "#menu",
				width: '100%',
				height: '80%',
				pageSelector: true,
				chapterSelector: false,
				arrows: false,
				tabs: true,
				arrowsHide:true
			});
			var updateOptions = function () {
				$('#options-list').children().remove();
				$.each(options, function(key, value){
					$('#options-list').append('<li>'+key+' <input value="'+value+'" id="option-'+key+'" /></li>');
					$('#option-'+key).on('change', function(e){
						e.preventDefault();
						var value = $(this).val();
						var intValue = parseInt(value);
						
						if(!isNaN(intValue)) {
							options[key] = intValue;
							return;
						}

						options[key] = value;
					});
				});
			};
			updateOptions();
			
			var config = $.extend({}, options, {
				create: updateSelect,
				add: updateSelect,
				remove: updateSelect
			});
			var mybook = $("#mybook").booklet(config);

			$('#gotoIndex').on('change', function(e){
				e.preventDefault();
				$('#custom-gotopage').click();
			});

			// New Page Default HTML

			var newPageCount = 0;
			var newPageHtml = function() {
				newPageCount++;
				return "<div rel='new chapter'>New Page \#"+newPageCount+"</div>";
			};
			
			
			// Display
			var display = $("#display");
			var updateDisplay = function(message) {
				display.text(message + '\r\n' + display.text());
			};

			// Demo Actions

			$('#custom-destroy').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet("destroy");
				updateDisplay('$("#mybook").booklet("destroy")');
			});

			$('#custom-create').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet(config);
				updateDisplay('$("#mybook").booklet();');
			});

			$('#custom-disable').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet("disable");
				updateDisplay('$("#mybook").booklet("disable")');
			});

			$('#custom-enable').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet("enable");
				updateDisplay('$("#mybook").booklet("enable")');
			});

			$('#custom-next').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet("next");
				updateDisplay('$("#mybook").booklet("next");');
			});

			$('#custom-prev').click(function (e) {
				e.preventDefault();
				$("#mybook").booklet("prev");
				updateDisplay('$("#mybook").booklet("prev");');
			});

			$('#custom-gotopage').click(function (e) {
				e.preventDefault();
				var index = $('#gotoIndex').val();
				$("#mybook").booklet("gotopage", index);
				updateDisplay('$("#mybook").booklet("gotopage", '+(index == "start" || index == "end" ? '"'+index+'"' : index)+');');
			});

			$('#custom-add-index').click(function (e) {
				e.preventDefault();
				var newPage = newPageHtml();
				var index = $('#addIndex').val();
				$("#mybook").booklet("add", index, newPage);
				updateDisplay('$("#mybook").booklet("add", '+ (index == "start" || index == "end" ? '"'+index+'"' : index) +', "'+ new String(newPage) +'");');
			});

			$('#custom-remove-index').click(function (e) {
				e.preventDefault();
				var index = $('#removeIndex').val();
				$("#mybook").booklet("remove", index);
				updateDisplay('$("#mybook").booklet("remove", '+ (index == "start" || index == "end" ? '"'+index+'"' : index) +');');
			});


		});
</script>


