<fieldset class="uk-margin-top">
    <legend data-uk-toggle="{target:'#seo-form'}">Cấu hình SEO</legend>
    <div id="seo-form" class="uk-form-horizontal">
        <div class="uk-form-row">
            <label class="uk-form-label" for="meta_title">Tiêu đề</title></label>
            <div class="uk-form-controls">
                <input class="uk-width-1-1" type="text" id="meta_title" name="meta_title" value="{{ isset($seo->meta_title) ? $seo->meta_title : '' }}" />
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" for="meta_keyword">Từ khóa</title></label>
            <div class="uk-form-controls">
                <input class="uk-width-1-1" type="text" id="meta_keyword" name="meta_keyword" value="{{ isset($seo->meta_keyword) ? $seo->meta_keyword : '' }}" />
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" for="meta_description">Mô tả</title></label>
            <div class="uk-form-controls">
                <textarea class="uk-width-1-1" id="meta_description" name="meta_description" cols="30" rows="5">{{ isset($seo->meta_description) ? $seo->meta_description : '' }}</textarea>
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" for="meta_index">Index trang</title></label>
            <div class="uk-form-controls">
                <label class="uk-margin-right"><input type="radio" name="meta_index" value="1" {{ (isset($seo->meta_index) && ($seo->meta_index == 1)) ? 'checked' : ''}} {{ isset($seo->meta_index) ? '' : 'checked'}}> Có</label>
                <label><input type="radio" name="meta_index" value="0" {{ (isset($seo->meta_index) && ($seo->meta_index == 0)) ? 'checked' : ''}}> Không</label>
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" for="meta_follow">Follow trang</title></label>
            <div class="uk-form-controls">
                <label class="uk-margin-right"><input type="radio" name="meta_follow" value="1" {{ (isset($seo->meta_follow) && ($seo->meta_follow == 1)) ? 'checked' : ''}} {{ isset($seo->meta_follow) ? '' : 'checked'}}> Có</label>
                <label><input type="radio" name="meta_follow" value="0" {{ (isset($seo->meta_follow) && ($seo->meta_follow == 0)) ? 'checked' : ''}}> Không</label>
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" for="canonical_url">Canonical url </title></label>
            <div class="uk-form-controls">
                <input class="uk-width-1-1" type="text" id="canonical_url" name="canonical_url" value="{{ isset($seo->canonical_url) ? $seo->canonical_url : '' }}" />
            </div>
        </div>
    </div>
</fieldset>