<div id="ModalPredlosci" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="form-horizontal" action="" method="POST">
            <input id="postMethod" type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Predlosci</h4>
                </div>
                <div class="modal-body">
                    nekaj
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" value="Submit">{{$gumbSpremiTxt}}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{$gumbZatvoriTxt}}</button>
                </div>
            </div>
        </form>
    </div>
</div>