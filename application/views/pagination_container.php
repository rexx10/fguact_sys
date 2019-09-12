<div class="container">
    <div class="starter-template">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 well text-left">
        <?php 
        $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
        echo form_open("pagination/search", $attr);?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info dropdown-toggle select_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="select_option_title"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="seach_option" name="所有資料" value="seach_0"><a>所有資料</a></li>
                                    <li class="seach_option" name="會議/活動" value="seach_1"><a>會議/活動</a></li>
                                    <li class="seach_option" name="教師" value="seach_2"><a>教師</a></li>
                                    <li class="seach_option" name="學年(期)" value="seach_3"><a>學年(期)</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" class="form-control" aria-label="..." placeholder="Search for Data..." value="<?php 
                                if(!empty($search_val)){
                                    if($search_val != "NIL"){
                                        echo $search_val;
                                    }
                                }
                            ?>"  name="search_data" />
                            <input type="hidden" name="sec_option" id="sec_option" <?php 
                                if(!empty($sec_option)){
                                    echo "value='".$sec_option."'";
                                }
                            ?>>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-md-6">
                        <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                        <a href="<?php echo base_url("pagination"); ?>" class="btn btn-primary">Show All</a>
                    </div>
                </div><!-- /.row -->
        <?php echo form_close(); ?>
        </div>
        <input type="hidden" name="tmp_search_val" id="tmp_search_val" value="<?php if(!empty($search_val)){
                echo $search_val;
            }else{
                echo "0";
                } ?>">
    </div>

