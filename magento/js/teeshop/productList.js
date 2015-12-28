function addToCart(url, isEngravable)
{
    if (isEngravable === 1) {
        bootbox.dialog({
            message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
                    '<form id="engraved_form" class="form-horizontal" action="' + url + '" method="POST"> ' +
                    '<input type="text" placeholder="Place your engrave here" name="engraved_name" id="engraved_name" value="" class="input-text" />' +
                    '<div class="price-box"><input type="submit" value="Ok" class="button "></div>' +
                    '</form> </div>  </div>'
        }
        );
    } else {
        setLocation(url);
    }
}