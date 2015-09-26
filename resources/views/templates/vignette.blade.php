@extends('framework-slide')
    
@section('header-include')
@stop

@section('content')

    <div class="modal modal-valign-center fade" id="vignette" tabindex="-1" role="dialog" aria-labelledby="vignetteLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="modal-title" id="vignetteLabel">Modal title</h3>
                            <p>One fine body&hellip;</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Continue</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <div class="jumbotron jumbotron-full-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <img src="http://user10.com/wp-content/uploads/2015/08/team-user10.jpg" />
                    <h1>[Slide header text]</h1>
                    <p>[Slide message] Phasellus eget libero auctor, varius tellus vel, tristique metus. Mauris auctor nibh sed nulla venenatis condimentum. Sed eleifend sapien est, a condimentum eros lacinia malesuada. Fusce imperdiet risus nec placerat aliquam. Pellentesque ut scelerisque lacus, a pharetra dui.</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                    <p><a href="">Mike</a></p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <p><a href="">Andrew</a></p>
                </div>
                <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                    <p><a href="">Brad</a></p>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <p><a href="">Josh</a></p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer-include')
    <script>
        // Vertically center our modals
        function centerModals($element) {
            var $modals;
            
            if ($element.length) {
                $modals = $element;
            } else {
                $modals = $('.modal-valign-center:visible');
            }
            
            $modals.each( function(i) {
                var $clone = $(this).clone().css('display', 'block').appendTo('body');
                var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
                top = top > 0 ? top : 0;
                $clone.remove();
                $(this).find('.modal-content').css("margin-top", top);
            });
        }
        
        $('.modal-valign-center').on('show.bs.modal', function(e) {
            centerModals($(this));
        });
        
        $(window).on('resize', centerModals);
        
        // FOR TESTING PURPOSES ONLY. Kill this after vignettes are fully functional
        $('#vignette').modal('show');
    </script>
@stop