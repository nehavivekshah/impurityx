<form action="{{ url('/my-account/my-notices') }}" method="POST">
    @csrf
    <div class="dashboard-area box--shadow mt-4 mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover rounded" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Notice ID</th>
                                <th>Message</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notices as $k=>$notice)
                                <tr>
                                    <td>{{ $k+1}}</td>
                                    <td>{{ $notice->notice_id }}</td>
                                    <td>{{ strlen($notice->message) > 150 ? substr($notice->message, 0, 150) . '...' : $notice->message }}</td>
                                    <!--<td>
                                        <span class="badge {{ $notice->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $notice->status == 'open' ? 'Open' : 'Closed' }}
                                        </span>
                                    </td>-->
                                    <td>{{ $notice->created_at }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-info view" id="{{ $notice->id }}" data-page="noticeview" title="View Details">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Notice found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>

@section('footlink')

<script>
    
    new DataTable('#example');
    
</script>

<script>
    
    $(document).ready(function(){
        
        $('.view').click(function(){
            var selector = $(this);
            var selectorId = selector.attr("id");
            var pagename = selector.attr("data-page");
            $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
            $.ajax({
                type: 'get',
                url: "/dbaction",
                data: {selectorId:selectorId,pagename:pagename},
                
                beforeSend: function(){
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
        
    });
</script>

<script>
  document.querySelector('.dismiss').addEventListener('click', function () {
    document.querySelector('.modal').style.display = 'none';
  });
</script>

@endsection