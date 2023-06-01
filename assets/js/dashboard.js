jQuery(document).ready(function(){  
    /** On Click on Delete record */
    jQuery('#userListing a.deleteBtn').click(function(){        
        var id = jQuery(this).closest('tr').attr('data-id');
        var url = 'delete-user.php?id='+id ; 
        jQuery('#deleteuserModal #deleteuserBtn').attr('href', url);
    });
});