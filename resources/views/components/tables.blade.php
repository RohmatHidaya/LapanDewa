<!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        {{ $thead }}
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        {{ $thead }}
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        {{ $slot }}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div