@extends('layouts.master')
@section('title','Fatura')
@section('content')
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar pt-10 mb-3">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Fatura Ekle</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="index.html" class="text-muted text-hover-primary">Anasayfa</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Uygulamalar</li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">Fatura Yöneticisi</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="#" class="btn btn-sm btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Üye Ekle</a>
                        <a href="#" class="btn btn-sm btn-flex btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Yeni Kampanya</a>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Form-->
                                <form action="{{ route('invoice.create') }}" id="kt_invoice_form" method="POST">
                                    <div class="alert alert-warning" role="alert">
                                        <span>Fatura bilgilerinizi eksiksiz ve doğru girdiğinizden emin olun. Yanlış bilgiler fatura işlemlerini etkileyebilir.</span>
                                    </div>
                                    @csrf
                                    @include('layouts.flash')
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Gün:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <input class="form-control form-control-transparent fw-bold pe-5" placeholder="Gün Seçiniz" name="invoice_date" />
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <i class="ki-outline ki-down fs-4 position-absolute ms-4 end-0"></i>
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                            <span class="fs-2x fw-bold text-gray-800">Fatura #</span>
                                            <input type="text" name="invoice_no" class="form-control form-control-flush fw-bold text-muted fs-3 w-125px" value="{{ $invoiceNo }}" placeholder="..." readonly />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice due date">
                                            <!--begin::Date-->
                                            <div class="fs-6 fw-bold text-gray-700 text-nowrap">Bitiş Tarihi:</div>
                                            <!--end::Date-->
                                            <!--begin::Input-->
                                            <div class="position-relative d-flex align-items-center w-150px">
                                                <!--begin::Datepicker-->
                                                <input class="form-control form-control-transparent fw-bold pe-5" placeholder="Gün Seçiniz" name="invoice_due_date" />
                                                <!--end::Datepicker-->
                                                <!--begin::Icon-->
                                                <i class="ki-outline ki-down fs-4 position-absolute end-0 ms-4"></i>
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Top-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed my-10"></div>
                                    <!--end::Separator-->
                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <!--begin::Col-->
                                            <div class="row gx-10 mb-5">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="address" class="form-label">Fatura Türü</label>
                                                        <select class="form-select form-select-solid" data-control="select2" data-placeholder="Fatura Türünü Seçiniz" name="invoice_type"  id="invoice_type">
                                                            <option></option>    
                                                            <option value="business">Kurumsal</option>
                                                            <option value="individual">Bireysel</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="company_name" class="form-label">Firma Adı</label>
                                                        <select class="form-select form-select-solid select2tag" id="company_name" name="company_name" >
                                                            <option></option>
                                                            @php
                                                                $shownNames = [];       
                                                            @endphp
                                                            @foreach($company as $companies)
                                                                @if(!in_array($companies->name, $shownNames))
                                                                    <option value="{{ $companies->name }}">{{ $companies->name }}</option>
                                                                    @php
                                                                        $shownNames[] = $companies->name;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gx-10 mb-5">
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="city" class="form-label">İsim</label>
                                                        <input type="text" id="user_name" class="form-control form-control-solid" name="user_name" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="district" class="form-label">Soyisim</label>
                                                        <input type="text" id="user_surname" class="form-control form-control-solid" name="user_surname" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="district" class="form-label">T.C Kimlik</label>
                                                        <input type="text" id="tc_id" class="form-control form-control-solid" name="tc_id" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-5">
                                                    <label for="address" class="form-label">Adres</label>
                                                    <input type="text" id="address" class="form-control form-control-solid" name="address" />
                                                </div>
                                            </div>
                                            <div class="row gx-10 mb-5">
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="city" class="form-label">İl</label>
                                                        <input type="text" id="city" class="form-control form-control-solid" name="city" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="district" class="form-label">İlçe</label>
                                                        <input type="text" id="district" class="form-control form-control-solid" name="district" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-5">
                                                        <label for="district" class="form-label">Ülke</label>
                                                        <input type="text" id="country" class="form-control form-control-solid" name="country" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row gx-10 mb-5">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" id="email" class="form-control form-control-solid" name="email" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="phone_number" class="form-label">Telefon Numarası</label>
                                                        <input type="text" id="phone_number" class="form-control form-control-solid" name="phone_number" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row gx-10 mb-5">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="tax_office" class="form-label">Vergi Dairesi</label>
                                                        <input type="text" id="tax_office" class="form-control form-control-solid" name="tax_office" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="tax_number" class="form-label">Vergi Numarası</label>
                                                        <input type="text" id="tax_number" class="form-control form-control-solid" name="tax_number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive mb-10">
                                            <!--begin::Table-->
                                            <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                        <th class="min-w-300px w-475px">Ürün</th>
                                                        <th class="min-w-100px w-100px">Adet</th>
                                                        <th class="min-w-150px w-150px">Fiyat</th>
                                                        <th class="min-w-150px w-150px">KDV</th>
                                                        <th class="min-w-100px w-150px text-end">Toplam</th>
                                                        <th class="min-w-75px w-75px text-end">Aksiyon</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody>
                                                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                        <td class="pe-7">
                                                            <input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Ürün Adı" />
                                                        </td>
                                                        <td class="ps-0">
                                                            <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-solid select2tag tax-rate-select" data-control="select2" data-placeholder="KDV Oranı %" name="tax_rate[]" onchange="myFunction()"  data-kt-element="tax-rate" >
                                                                <option></option>
                                                                <option value="20">%20</option>
                                                                <option value="10">%10</option>
                                                                <option value="1">%1</option>
                                                            </select>
                                                        </td>
                                                        <td class="pt-8 text-end text-nowrap">$
                                                        <span data-kt-element="total">0.00</span></td>
                                                        <td class="pt-5 text-end">
                                                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                                <i class="ki-outline ki-trash fs-3"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!--end::Table body-->
                                                <!--begin::Table foot-->
                                                <tfoot>
                                                    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                        <th class="text-primary">
                                                            <button class="btn btn-link py-1" data-kt-element="add-item">Ürün Ekle</button>
                                                        </th>
                                                        <th colspan="3" class="border-bottom border-bottom-dashed ps-0">
                                                            <div class="d-flex flex-column align-items-start">
                                                                <div class="fs-5">Ara Toplam</div>
                                                            </div>
                                                        </th>
                                                        <th class="border-bottom border-bottom-dashed text-end">$ 
                                                            <span data-kt-element="sub-total">0.00</span>
                                                        </th>
                                                    </tr>
                                                    
                                                    <tr class="align-top fw-bold text-gray-700">
                                                        <th></th>
                                                        <th colspan="3" class="ps-0">KDV(%)</th>
                                                        <th class="text-end">
                                                            <p id="demo"></p>
                                                        </th>
                                                    </tr>
                                                    <tr class="align-top fw-bold text-gray-700">
                                                        <th></th>
                                                        <th colspan="3" class="ps-0">Toplam KDV</th>
                                                        <th class="text-end">$ 
                                                            <span data-kt-element="tax-total" >0.00</span> <!-- Toplam KDV -->
                                                            <input type="hidden" name="tax_amount" id="tax_amount" value="0.00" />
                                                        </th>
                                                    </tr>
                                                    <tr class="align-top fw-bold text-gray-700">
                                                        <th></th>
                                                        <th colspan="3" class="ps-0 fs-4">KDV Dahil Toplam</th>
                                                        <th class="text-end fs-4 text-nowrap">$ 
                                                            <span data-kt-element="grand-total">0.00</span>
                                                        </th>
                                                        <input type="hidden" name="invoice_total" id="invoice_total" value="0.00" />
                                                    </tr>
                                                </tfoot>
                                                <!--end::Table foot-->
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        <!--begin::Item template-->
                                        <table class="table d-none" data-kt-element="item-template">
                                             <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                <td class="pe-7">
                                                    <input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Ürün Adı" />
                                                </td>
                                                <td class="ps-0">
                                                    <input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-solid tax-rate-select"  data-placeholder="KDV Oranı %" name="tax_rate[]"  data-kt-element="tax-rate" onchange="myFunction()" id="taxRateSelect2">
                                                        <option></option>
                                                        <option value="20">%20</option>
                                                        <option value="10">%10</option>
                                                        <option value="1">%1</option>
                                                    </select>
                                                </td>
                                                <td class="pt-8 text-end text-nowrap">$
                                                <span data-kt-element="total">0.00</span></td>
                                                <td class="pt-5 text-end">
                                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                        <i class="ki-outline ki-trash fs-3"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table d-none" data-kt-element="empty-template">
                                            <tr data-kt-element="empty">
                                                <th colspan="5" class="text-muted text-center py-10">No items</th>
                                            </tr>
                                        </table>
                                        <!--end::Item template-->
                                        <!--begin::Notes-->
                                        <div class="d-flex justify-content-end mb-0">
                                            <button type="submit" class="btn btn-primary" id="kt_invoice_submit_button">
                                                <i class="ki-outline ki-triangle fs-3"></i> Faturayı Gönder
                                            </button>
                                        </div>
                                        <!--end::Notes-->
                                    </div>
                                    <!--end::Wrapper-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end:::Main-->
@endsection

@section('js')
    <!--end::Modal - Invite Friend-->
        <!--end::Modals-->
        <!--begin::Javascript-->
        <script>var hostUrl = "{{ asset('assets/') }}";</script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Vendors Javascript(used for this page only)-->
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <!--end::Vendors Javascript-->
        <!--begin::Custom Javascript(used for this page only)-->
        <script src="{{ asset('assets/js/custom/apps/invoices/create.js') }}"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
        <!-- Sayfa sonunda, scriptlerin hemen sonrasında -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
        <!--end::Custom Javascript-->
        <!--end::Javascript-->
        <script>
            function myFunction() {
                // Tüm tax-rate-select sınıfına sahip select öğelerini seç
                const selects = document.querySelectorAll(".tax-rate-select");
                let result = "";

                // Her bir select öğesinin seçili değerini al
                selects.forEach((select, index) => {
                    const value = select.value;

                    // Eğer seçili değer boş değilse sonucu ekle
                    if (value) {
                        result += "%" + value;

                        // Son select öğesi dışında araya virgül koy
                        if (index < selects.length - 1) {
                            result += ", ";
                        }
                    }
                });

                // Sonuçları demo ID'li öğeye yazdır
                document.getElementById("demo").innerHTML = result || "Lütfen bir KDV oranı seçin.";
            }
        </script>
        <script>
            $(document).ready(function () {
                // Select2 başlat
                $('#invoice_type').select2({
                    placeholder: "Fatura Türünü Seçiniz",
                    allowClear: true
                });

                // Fatura türü değiştiğinde
                $('#invoice_type').on('change', function () {
                    const invoiceType = $(this).val();
                    const companyNameField = $('#company_name');


                    if (invoiceType === "business") {
                        companyNameField.prop('disabled', false); // Etkinleştir
                    } else {
                        companyNameField.prop('disabled', true); // Devre dışı bırak
                        companyNameField.val(null).trigger('change'); // Değer sıfırla
                    }
                });
            });

        </script>
        <script>
                $(document).ready(function() {
                    // İlk başta Select2'yi başlat
                    initializeSelect2();


                    // Fiyat, miktar veya KDV oranı değiştiğinde hesaplamayı güncelle
                    $(document).on('input', '[data-kt-element="price"], [data-kt-element="quantity"], [data-kt-element="tax-rate"]', function() {
                        updateTotals();
                    });

                    // Ürün silme butonuna tıklanırsa ürünü sil
                    $(document).on('click', '[data-kt-element="remove-item"]', function() {
                        $(this).closest('tr').remove();
                        updateTotals(); // Satır silindiğinde toplamları güncelle
                    });

                    // Fiyat input'tan çıkıldığında KDV hesaplama
                    $(document).on('blur', '[data-kt-element="price"], [data-kt-element="quantity"], [data-kt-element="tax-rate"]', function() {
                        updateTotals();
                    });

                    // KDV hesaplaması ve toplamları güncelleme fonksiyonu
                    function updateTotals() {
                        var subTotal = 0;
                        var taxTotal = 0;
                        var grandTotal = 0;

                        // Ürünleri her birini kontrol et
                        $('tbody tr').each(function() {
                            var quantity = $(this).find('[data-kt-element="quantity"]').val();
                            var price = $(this).find('[data-kt-element="price"]').val();
                            var taxRate = $(this).find('[data-kt-element="tax-rate"]').val();

                            // Veriler geçerli mi kontrol et
                            if (quantity && price && taxRate) {
                                quantity = parseNumber(quantity); // Sayıyı sayıya çevir
                                price = parseNumber(price); // Sayıyı sayıya çevir
                                taxRate = parseFloat(taxRate);

                                // Ürün toplamını hesapla (fiyat * adet)
                                var total = price * quantity;

                                // KDV miktarını hesapla (total * KDV oranı)
                                var taxAmount = (total * taxRate) / 100;

                                // KDV dahil toplamı hesapla
                                var totalWithTax = total + taxAmount;

                                // Satırdaki KDV ve toplam değerlerini güncelle
                                $(this).find('[data-kt-element="total"]').text(totalWithTax.toFixed(2));
                                $(this).find('[data-kt-element="tax-total"]').text(taxAmount.toFixed(2)); // KDV miktarını yaz

                                // Ara toplam, KDV toplamı ve genel toplamı hesapla
                                subTotal += total;
                                taxTotal += taxAmount;
                                grandTotal += totalWithTax;
                            }
                        });

                        // Ara Toplam, KDV Toplamı ve Genel Toplamı güncelle
                        $('[data-kt-element="sub-total"]').text(subTotal.toFixed(2));
                        $('[data-kt-element="tax-total"]').text(taxTotal.toFixed(2));
                        $('[data-kt-element="grand-total"]').text(grandTotal.toFixed(2));
                    }

                    // Sayıları doğru biçimde sayıya dönüştür
                    function parseNumber(value) {
                        // Virgül ve nokta ayırıcılarını kaldır, sayıyı parse et
                        value = value.replace(/[^\d.-]/g, '');  // Sadece rakamları ve nokta işaretini kabul et
                        return parseFloat(value) || 0; // Sayıya çevir
                    }

                    // Sayfa yüklendiğinde Select2'yi başlat
                    function initializeSelect2() {
                        $('.select2tags').each(function() {
                            if (!$(this).data('select2')) {  // Eğer select2 zaten başlatılmadıysa başlat
                                $(this).select2({
                                    placeholder: "KDV Oranı %",
                                    allowClear: true
                                });
                            }
                        });
                    }
                });

        </script>

        <script>
            // Date
                Inputmask({
                    "mask" : "99/99/9999"
                }).mask("#kt_inputmask_1");

                // Phone
                Inputmask({
                    "mask" : "(999) 999-9999"
                }).mask("#kt_inputmask_2");

                // Placeholder
                Inputmask({
                    "mask" : "(999) 999-9999",
                    "placeholder": "(999) 999-9999",
                }).mask("#kt_inputmask_3");

                // Repeating
                Inputmask({
                    "mask": "9",
                    "repeat": 10,
                    "greedy": false
                }).mask("#kt_inputmask_4");

                // Right aligned
                Inputmask("decimal", {
                    "rightAlignNumerics": false
                }).mask("#kt_inputmask_5");

                // Currency
                Inputmask("€ 999.999.999,99", {
                    "numericInput": true
                }).mask("#kt_inputmask_6");

                // Ip address
                Inputmask({
                    "mask": "999.999.999.999"
                }).mask("#kt_inputmask_7");

                // Email address
                Inputmask({
                    mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
                    greedy: false,
                    onBeforePaste: function (pastedValue, opts) {
                        pastedValue = pastedValue.toLowerCase();
                        return pastedValue.replace("mailto:", "");
                    },
                    definitions: {
                        "*": {
                            validator: '[0-9A-Za-z!#$%&"*+/=?^_`{|}~\-]',
                            cardinality: 1,
                            casing: "lower"
                        }
                    }
                }).mask("#kt_inputmask_8");
        </script>
        
       <script>
            // Rastgele 7 rakamlı fatura numarası oluştur
            function generateRandomInvoiceNumber() {
                return String(Math.floor(1000000 + Math.random() * 9000000));
            }

            // Form yüklenirken fatura numarasını ayarla
            document.addEventListener('DOMContentLoaded', function() {
                const invoiceNumberInput = document.getElementById('invoiceNumber');
                invoiceNumberInput.value = generateRandomInvoiceNumber();
            });
        </script>

        <script>
          function updateInvoiceTotal() {
            let grandTotal = 0;

            // Fatura toplamını hesapla (örneğin, ürünlerin toplamı)
            $('tr.product-row').each(function() {
                let quantity = parseFloat($(this).find('input[name="quantity"]').val()) || 0;
                let price = parseFloat($(this).find('input[name="price"]').val()) || 0;
                let total = quantity * price;
                grandTotal += total;
            });

            // `invoice_total` input alanını güncelle
            $('#invoice_total').val(grandTotal.toFixed(2));
            $('span[data-kt-element="grand-total"]').text(grandTotal.toFixed(2));
        }

        // Örneğin bir butona tıklandığında veya form submit edilmeden önce bu fonksiyonu çağırabilirsiniz
        $('form').on('submit', function(e) {
            updateInvoiceTotal();
        });

        </script>
        <script>
            $(document).ready(function() {
                $('#company_name').change(function() {
                    var companyName = $(this).val();

                    if (companyName) {
                        $.ajax({
                            url: '{{ route("invoice.create") }}',
                            type: 'GET',
                            data: { company_name: companyName }, // name değeri ile istek gönderiyoruz
                            success: function(response) {
                                if (response) {
                                    $('#user_name').val(response.user_name);
                                    $('#user_surname').val(response.user_surname);
                                    $('#address').val(response.address);
                                    $('#city').val(response.city);
                                    $('#district').val(response.district);
                                    $('#country').val(response.country);
                                    $('#tc_id').val(response.tc_id);
                                    $('#email').val(response.email);
                                    $('#phone_number').val(response.phone_number);
                                    $('#tax_office').val(response.tax_office);
                                    $('#tax_number').val(response.tax_number);
                                }
                            },
                            error: function() {
                                alert('Firma bilgileri bulunamadı.');
                            }
                        });
                    }
                });
            });


        </script>

       

        <script>
            $(document).ready(function()
                {
                    // Initialize the select with tags enabled.

                    $(".select2tag").select2(
                    {
                        placeholder: 'Firma Adınızı Giriniz',
                        tags: true
                    });

                    // Register a listener on the change event.

                    $(".select2tag").change(function()
                    {
                        $(this).find("option").removeAttr("data-select2-tag");
                    });
            });
        </script>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: "{{ session('success') }}",
                });
            </script>
        @endif

        <script>
            $(document).ready(function() {
                // Select2 yapılandırması
                $('#company_name').select2({
                    tags: true,  // Kullanıcı yeni değerler yazabilir
                    placeholder: "Firma Adını Giriniz",  // Placeholder metni
                    allowClear: true  // Temizleme butonu
                });

                // Yeni girilen değeri option'a ekleme işlemi
                $('#company_name').on('select2:select', function (e) {
                    var newOption = e.params.data.text;  // Yeni yazılan değeri al

                    // Yeni değeri yalnızca bir kez eklemek için kontrol
                    var exists = false;
                    $('#company_name option').each(function() {
                        if ($(this).val() === newOption) {
                            exists = true;
                        }
                    });

                    // Eğer yazılan değer option listesinde yoksa, ekle
                    if (!exists) {
                        var newOptionElement = new Option(newOption, newOption, true, true);
                        $('#company_name').append(newOptionElement).trigger('change');
                    }
                });

                // Seçilen değeri silme (unselect) işlemi
                $('#company_name').on('select2:unselect', function (e) {
                    var removedOption = e.params.data.id;

                    // Burada, kullanıcının sildiği değeri listeden temizleyebilirsiniz
                    // Ancak Select2, sadece yazılan değeri değil, tüm option'ları da yönetiyor
                    $('#company_name option').each(function() {
                        if ($(this).val() === removedOption) {
                            $(this).remove();
                        }
                    });

                    // Change trigger ile Select2'yi güncelle
                    $('#company_name').trigger('change');
                });
            });

        </script>

        

        
@endsection

