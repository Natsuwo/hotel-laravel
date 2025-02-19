<div class="col-md-8 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="card-title mb-1">Room Availability</h4>
                <p class="text-muted mb-1">Your data status</p>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="preview-list">
                        <x-room-status title="Occupied" description="The room is occupied by guests."
                            icon-bg="bg-primary" time="15 minutes ago" value="236" icon="mdi mdi-bed-empty" />
                        <x-room-status title="Available" description="The room is available for guests."
                            icon-bg="bg-success" time="15 minutes ago" value="25" icon="mdi mdi-bed-empty" />
                        <x-room-status title="Reserved" description="The room is reserved for guests."
                            icon-bg="bg-warning" time="15 minutes ago" value="23" icon="mdi mdi-bed-empty" />
                        <x-room-status title="Not Ready" description="The room is under maintenance."
                            icon-bg="bg-danger" time="15 minutes ago" value="16" icon="mdi mdi-bed-empty" />

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
