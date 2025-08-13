<!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-left">
                                        {{ $thead }}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {{ $slot }}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div