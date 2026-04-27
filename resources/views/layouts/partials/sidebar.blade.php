<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset ('/img/logo_kpf.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ photo_user() }}" class="img-circle elevation-2" alt="User Image" style="height: 58px;width:58px;">
            </div>
            <div class="info">
                <a href="{{route('user.profile')}}" class="d-block profile">{{name_user()}}</a>
                <span class="d-block profile">{{role_user()}}</span>
                <span class="d-block profile">{{user_location()}}</span>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(check_access('dashboard','view'))
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link  {{ Route::currentRouteName() ==  'home' ? 'active' : '' }}"><i class="nav-icon fas fa-home"></i><p> Dashboard</p></a>
                </li>
                @endif
                @if(check_access('simulasi_pinjaman','view'))
                <li class="nav-item">
                    <a href="{{route('simulation.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'simulation.index' ? 'active' : '' }}"><i class="nav-icon  fas fa-calculator"></i><p> Simulasi Pinjaman</p></a>
                </li>
                @endif
                @if(check_access('approval_bank','view') || check_access('pengajuan_slik','view') || check_access('verifikasi_slik','view') || check_access('verifikasi_pembiayaan','view'))
                <li class="nav-item {{ in_array(Route::currentRouteName(),['application.loan.index','application.slik.index','application.verification.index','application.approval.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(),['application.loan.index','application.slik.index','application.verification.index','application.approval.index']) ? 'active' : '' }}"><i class="nav-icon fas fa-tasks"></i><p> Pengajuan <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        @if(check_access('pengajuan_slik','view'))
                            <li class="nav-item">
                                <a href="{{route('application.loan.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.loan.index' ? 'active' : '' }}"><i class="nav-icon "></i><p> Pengajuan Slik</p></a>
                            </li>
                        @endif
                        @if(check_access('verifikasi_slik','view'))
                            <li class="nav-item">
                                <a href="{{route('application.slik.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.slik.index' ? 'active' : '' }}"><i class="nav-icon "></i><p> Verifikasi Slik</p></a>
                            </li>
                        @endif
                        @if(check_access('verifikasi_pembiayaan','view'))
                            <li class="nav-item">
                                <a href="{{route('application.verification.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.verification.index' ? 'active' : '' }}"><i class="nav-icon "></i><p> Verifikasi Pembiayaan</p></a>
                            </li>
                        @endif
                        @if(check_access('approval_bank','view'))
                            <li class="nav-item">
                                <a href="{{route('application.approval.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.approval.index' ? 'active' : '' }}"><i class="nav-icon "></i><p> Approval Bank</p></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(check_access('cetak_si_pencairan','view') || check_access('pencairan','view') || check_access('pencairan_tahap_2','view') || check_access('upload_dokumen','view'))
                <li class="nav-item {{ in_array(Route::currentRouteName(),['application.internal.si-disbursement','application.internal.disbursement','application.internal.second-disbursement','application.internal.document']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link  {{ in_array(Route::currentRouteName(),['application.internal.si-disbursement','application.internal.disbursement','application.internal.second-disbursement','application.internal.document']) ? 'active' : '' }}"><i class="nav-icon fas fa-tasks"></i><p> Pengajuan Internal <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        @if(check_access('cetak_si_pencairan','view'))
                            <li class="nav-item">
                                <a href="{{route('application.internal.si-disbursement')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.internal.si-disbursement' ? 'active' : '' }}"><i class="nav-icon "></i><p> Cetak SI Pencairan</p></a>
                            </li>
                        @endif
                        @if(check_access('pencairan','view'))
                            <li class="nav-item">
                                <a href="{{route('application.internal.disbursement')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.internal.disbursement' ? 'active' : '' }}"><i class="nav-icon "></i><p> Pencairan</p></a>
                            </li>
                        @endif
                        @if(check_access('pencairan_tahap_2','view'))
                            <li class="nav-item">
                                <a href="{{route('application.internal.second-disbursement')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.internal.second-disbursement' ? 'active' : '' }}"><i class="nav-icon "></i><p> Pencairan Tahap 2</p></a>
                            </li>
                        @endif
                        @if(check_access('upload_dokumen','view'))
                            <li class="nav-item">
                                <a href="{{route('application.internal.document')}}" class="nav-link  {{ Route::currentRouteName() ==  'application.internal.document' ? 'active' : '' }}"><i class="nav-icon "></i><p> Upload Dokumen</p></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(check_access('monitoring_pembiayaan','view'))
                    <li class="nav-item">
                        <a href="{{route('monitoring.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'monitoring.index' ? 'active' : '' }}"><i class="nav-icon fas fa-eye"></i><p> Monitoring Pembiayaan</p></a>
                    </li>
                @endif
                @if(check_access('angsuran','view'))
                    <li class="nav-item">
                        <a href="{{route('installment.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'installment.index' ? 'active' : '' }}"><i class="nav-icon fas fa-calendar-check"></i><p> Angsuran</p></a>
                    </li>
                @endif
                @if(check_access('berkas_pembiayaan','view') || check_access('cetak_berkas_penyerahan','view') || check_access('upload_surat_berkas','view') || check_access('cetak_penyerahan_jaminan','view') || check_access('upload_jaminan','view'))
                <li class="nav-item {{ in_array(Route::currentRouteName(),['files.applications','files.submission','files.get.submission-files','files.guarantee','files.get.guarantee-files']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(),['files.applications','files.submission','files.get.submission-files','files.guarantee','files.get.guarantee-files']) ? 'active' : '' }}"><i class="nav-icon fas fa-file-archive"></i><p> Pemberkasan <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        @if(check_access('berkas_pembiayaan','view'))
                            <li class="nav-item">
                                <a href="{{route('files.applications')}}" class="nav-link  {{ Route::currentRouteName() ==  'files.applications' ? 'active' : '' }}"><i class="nav-icon "></i><p> Berkas Pembiayaan</p></a>
                            </li>
                        @endif
                        @if ( check_access('cetak_berkas_penyerahan','view'))
                            <li class="nav-item">
                                <a href="{{route('files.submission')}}" class="nav-link  {{ Route::currentRouteName() ==  'files.submission' ? 'active' : '' }}"><i class="nav-icon "></i><p> Cetak Berkas Penyerahan</p></a>
                            </li>
                        @endif
                        @if (check_access('upload_surat_berkas','view'))
                            <li class="nav-item">
                                <a href="{{route('files.get.submission-files')}}" class="nav-link  {{ Route::currentRouteName() ==  'files.get.submission-files' ? 'active' : '' }}"><i class="nav-icon "></i><p> Upload Surat Berkas</p></a>
                            </li>
                        @endif
                        @if (check_access('cetak_penyerahan_jaminan','view'))
                            <li class="nav-item">
                                <a href="{{route('files.guarantee')}}" class="nav-link  {{ Route::currentRouteName() ==  'files.guarantee' ? 'active' : '' }}"><i class="nav-icon "></i><p> Cetak Penyerahan Jaminan</p></a>
                            </li>
                        @endif
                        @if (check_access('upload_jaminan','view'))
                            <li class="nav-item">
                                <a href="{{route('files.get.guarantee-files')}}" class="nav-link  {{ Route::currentRouteName() ==  'files.get.guarantee-files' ? 'active' : '' }}"><i class="nav-icon "></i><p> Upload Jaminan</p></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(check_access('laporan','view') || check_access('laporan_cash_flow','view') || check_access('laporan_outstanding','view') || check_access('laporan_monthly','view')
                    || check_access('laporan_fixed_cost','view') || check_access('laporan_alternative_cost','view') || check_access('laporan_insurance','view') || check_access('laporan_debtor','view')
                )
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['report.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['report.index']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-archive"></i>
                        <p> Laporan Administrasi <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                            <a href="{{route('report.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.index' ? 'active' : '' }}"><i class="nav-icon "></i><p> Daftar Nominatif</p></a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{route('report.cash-flow')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.cash-flow' ? 'active' : '' }}"><i class="nav-icon "></i><p> Arus Kas</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.outstanding')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.outstanding' ? 'active' : '' }}"><i class="nav-icon "></i><p> Daftar Outstanding Aktif</p></a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{route('report.monthly')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.monthly' ? 'active' : '' }}"><i class="nav-icon "></i><p> Laporan Bulanan</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.fixed-cost')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.fixed-cost' ? 'active' : '' }}"><i class="nav-icon "></i><p> Fixed Cost</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.alternative-cost')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.alternative-cost' ? 'active' : '' }}"><i class="nav-icon "></i><p> Alternative Cost</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('report.insurance')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.insurance' ? 'active' : '' }}"><i class="nav-icon "></i><p> Pembayaran Asuransi</p></a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{route('report.debtor')}}" class="nav-link  {{ Route::currentRouteName() ==  'report.debtor' ? 'active' : '' }}"><i class="nav-icon "></i><p> Pelunasan Debitur</p></a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(check_access('data_bisnis','view'))
                    <li class="nav-item">
                        <a href="{{route('business-data.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'business-data.index' ? 'active' : '' }}"><i class="nav-icon fas fa-briefcase"></i><p> Data Bisnis</p></a>
                    </li>
                @endif
                @if(check_access('absensi_karyawan','view') || check_access('laporan_absensi_karyawan','view'))
                    <li class="nav-item {{ in_array(Route::currentRouteName(),['attendance.index','attendance.report']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ in_array(Route::currentRouteName(),['attendance.index','attendance.report']) ? 'active' : '' }}"><i class="nav-icon fas fa-users"></i><p> Absensi Karyawan <i class="right fas fa-angle-left"></i></p></a>
                        <ul class="nav nav-treeview">
                            @if (check_access('absensi_karyawan','view'))
                            <li class="nav-item">
                                <a href="{{route('attendance.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'attendance.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Kehadiran</p></a>
                            </li>
                            @endif
                            @if(check_access('laporan_absensi_karyawan','view'))
                            <li class="nav-item">
                                <a href="{{route('attendance.report')}}" class="nav-link  {{ Route::currentRouteName() ==  'attendance.report' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Laporan Kehadiran</p></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(check_access('master_data_pembiayaan','view') || check_access('master_data_taspen','view') || check_access('master_data_referral','view') || check_access('master_data_karyawan','view') || check_access('master_data_pelayanan','view') || check_access('master_data_cabang','view'))
                <li class="nav-item {{ in_array(Route::currentRouteName(),['master-data.finance.index','master-data.taspen.index','master-data.referral.index','master-data.employee.index','master-data.service-unit.index','master-data.branch-unit.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(),['master-data.finance.index','master-data.taspen.index','master-data.referral.index','master-data.employee.index','master-data.service-unit.index','master-data.branch-unit.index']) ? 'active' : '' }}"><i class="nav-icon fas fa-database"></i><p> Master Data <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        @if (check_access('master_data_pembiayaan','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.finance.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.finance.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Master Pembiayaan</p></a>
                            </li>
                        @endif
                        @if (check_access('master_data_taspen','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.taspen.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.taspen.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Data Taspen</p></a>
                            </li>
                        @endif
                        @if (check_access('master_data_referral','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.referral.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.referral.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Data Referral</p></a>
                            </li>
                        @endif
                        @if (check_access('master_data_karyawan','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.employee.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.employee.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Data karyawan</p></a>
                            </li>
                        @endif
                        @if (check_access('master_data_pelayanan','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.service-unit.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.service-unit.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Unit Pelayanan</p></a>
                            </li>
                        @endif
                        @if (check_access('master_data_cabang','view'))
                            <li class="nav-item">
                                <a href="{{route('master-data.branch-unit.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'master-data.branch-unit.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p> Unit Cabang</p></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(check_access('user','view') || check_access('role_user','view'))
                <li class="nav-item  {{ in_array(Route::currentRouteName(),['user.index','role.index']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link  {{ in_array(Route::currentRouteName(),['user.index','role.index']) ? 'active' : '' }}"><i class="nav-icon fas fa-user-cog"></i><p> Pengaturan Pengguna <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        @if (check_access('user','view'))
                            <li class="nav-item">
                                <a href="{{route('user.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'user.index' ? 'active' : '' }}"><i class="nav-icon far fa-circle"></i><p> Pengguna</p></a>
                            </li>
                        @endif
                        @if (check_access('role_user','view'))
                            <li class="nav-item">
                                <a href="{{route('role.index')}}" class="nav-link  {{ Route::currentRouteName() ==  'role.index' ? 'active' : '' }}"><i class="nav-icon far fa-circle"></i><p> Jabatan </p></a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
