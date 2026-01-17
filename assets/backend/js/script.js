/*window.onload = function(){
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const searchBtn = document.querySelector(".bx-search")

    closeBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    searchBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    function menuBtnChange(){
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu","bx-menu-alt-right")
        }else{
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu")
        }
    }
}*/

$(document).ready(function(){
    
    $(document).on('click', '.view', function(){
        var selector = $(this);
        var selectorId = selector.attr("id");
        var pagename = selector.attr("data-page");
        
        $('.content').html("<div class='spinner'><p class='loader'></p></div");
        $.ajax({
            type: 'get',
            url: "/admin/dbaction",
            data: {selectorId:selectorId,pagename:pagename},
            
            beforeSend: function(){
                
                if (pagename == "csreply") {
                    $(".poptitle").html("Reply to Buyer");
                }else if (pagename == "csAreply") {
                    $(".poptitle").html("Reply to Buyer");
                } else if (pagename == "csupport") {
                    $(".poptitle").html("View Details");
                }
                
                $('.modal').attr("style","display:flex;width:100%;height:100vh;");
            },
            success: function(response){
                
                $('.content').html(response);

                //alert(response);
                console.log(response);
                
            },
            complete: function(response){
                //alert(response);
                //console.log(response);
            }
        });
    });
    
    $(document).on('click', '.status', function(){
        var selector = $(this);
        var pagename = selector.attr("data-page");
        var rowid = selector.attr("id");
        var rowstatus = selector.attr("data-status");
        if(rowstatus=='1'){ $s="Activate"; }else{ $s="Deactivate"; }
        //alert(rowid);
        //$('.content').html("<div class='spinner'><p class='loader'></p></div");
        swal({
            title: "Are you sure?",
            text: "You want to "+$s+" this row??",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: "/admin/dbaction",
                    data: {pagename:pagename,rowid:rowid,rowstatus:rowstatus},
                    
                    beforeSend: function(){
                        //$('.modal').attr("style","display:flex;width:100%;height:100vh;");
                    },
                    success: function(response){
                        if(response == '1'){
                            selector.html("Active");
                            selector.attr("date-status",'1');
                            selector.attr("class",'notify alert-success qryrowstatus');
                        }else{
                            selector.html("Deactive");
                            selector.attr("date-status",'0');
                            selector.attr("class",'notify alert-danger qryrowstatus');
                        }
                        location.reload();
                        //alert(response);
                        //console.log(response);
                    },
                    complete: function(response){
                        //alert(response);
                        //console.log(response);
                    }
                });
            } else {
                swal("This row status not updated");
            }
        });
    });

    $(document).on('click', '.delete', function(){
        var selector = $(this);
        var pagename = selector.attr("data-page");
        var rowid = selector.attr("id");
        //alert(rowid);
        //$('.content').html("<div class='spinner'><p class='loader'></p></div");
        swal({
            title: "Are you sure?",
            text: "You want to delete this row??",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: "/admin/dbaction",
                    data: {pagename:pagename,rowid:rowid},
                    
                    beforeSend: function(){
                        //$('.modal').attr("style","display:flex;width:100%;height:100vh;");
                    },
                    success: function(response){
                        if(response=='true'){ selector.parent().parent().hide(); }
                        if(response=='buyer_not_deleted'){ swal("Orders existing for this buyer. Cannot be deleted ! You can choose to deactivate it."); }
                        if(response=='seller_not_deleted'){ swal("Transaction / Bids exist for this Seller. Cannot be deleted ! You can choose to deactivate it."); }
                        //alert(response);
                        //console.log(response);
                    },
                    complete: function(response){
                        //alert(response);
                        //console.log(response);
                    }
                });
            } else {
                swal("This row is safe.");
            }
        });
    });

    $('#m-menu').click(function(){
        //alert("Hello");
        if($('#mob-menu').attr("class")=='mobile-sidebar mobile'){
            $('#mob-menu').attr('class', 'mobile-sidebar open mobile');
        }else{
            $('#mob-menu').attr('class', 'mobile-sidebar mobile');
        }
        
    });
    
    $('.dismiss').click(function(){
        $('.modal').removeAttr("style","width:0%;height:0vh;display:none;");
    });
});