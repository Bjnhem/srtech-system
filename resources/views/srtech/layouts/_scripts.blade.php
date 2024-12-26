<!-- Backend Bundle JavaScript -->
<script src="{{ asset('js/libs.min.js') }}"></script>
<script src="{{ asset('js/hope-ui.js') }}"></script>



{{-- <script src="{{asset('js/plugins/circle-progress.js') }}"></script> --}}
<script src="{{ asset('checklist-ilsung/js/toastr.min.js') }}"></script>
<script src="{{ asset('smart-ver2/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
{{-- <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker-full.js') }}"></script> --}}
{{-- <script src="{{ asset('smart-ver2/jquery-tabledit/jquery.tabledit.js') }}"></script> --}}

@stack('scripts')
