<div id="logout_popup" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Vaša sesija uskoro će isteći!</h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 15px;">Automatski logout za <span id="timer" style="display: inline;font-size: 30px;font-style: bold">10</span> sekundi.</p>
                <p style="font-size: 15px;">Da li želite ostati ulogirani?</p>
            </div>
            <div class="modal-footer">
                <a id="resetVremena" class="btn btn-primary" aria-hidden="true">Nastavak rada</a>
                <a href="{{url('auth/logout')}}" class="btn btn-danger" aria-hidden="true">Završi rad</a>
            </div>
        </div>
    </div>
</div>