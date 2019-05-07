<ul class="list-inline links-list pull-right">
	<li>
		<div class="search">
			<input type="text" class="form-control input-sm" maxlength="64" placeholder="Search" />
				 <button type="submit" class="btn btn-primary btn-sm">Search</button>
		</div>				
	</li>
	<li>			
		<div class="btn-group pull-right">
			<button class="btn btn-default" title="<?=get_phrase('back');?>" onclick="javascript:go_back();"><i class="fa fa-backward"></i></button>
			<button class="btn btn-default" title="<?=get_phrase('forward');?>" onclick="javascript:go_forward();"><i class="fa fa-forward"></i></button>
		</div>
	</li>
</ul>


<style>
	#search {
    float: right;
    margin-top: 9px;
    width: 250px;
}

.search {
    padding: 5px 0;
    width: 230px;
    height: 30px;
    position: relative;
    left: 10px;
    float: left;
    line-height: 22px;
}

    .search input {
        position: absolute;
        width: 0px;
        float: Left;
        margin-left: 210px;
        -webkit-transition: all 0.7s ease-in-out;
        -moz-transition: all 0.7s ease-in-out;
        -o-transition: all 0.7s ease-in-out;
        transition: all 0.7s ease-in-out;
        height: 30px;
        line-height: 18px;
        padding: 0 2px 0 2px;
        border-radius:1px;
    }

        .search:hover input, .search input:focus {
            width: 200px;
            margin-left: 0px;
        }

.btn {
    height: 30px;
    position: absolute;
    right: 0;
    top: 5px;
    border-radius:1px;
}

</style>