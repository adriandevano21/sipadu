<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Scan QRCode</h5>
        <div class="header-elements">
            <div class="list-icons">
                <!-- <a class="list-icons-item" data-action="collapse"></a> -->
                <!-- <a class="list-icons-item" data-action="reload"></a> -->
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
            </div>
        </div>
    </div>

    <div class="card-body">
        <div style="margin: auto; text-align: center;">
            <video id="previewKamera" style="max-width: 300px;max-height: 300px; " class="embed-responsive-item"></video>
            <!-- <video id="previewKamera" class="embed-responsive-item" style="max-width: 500px;max-height: 500px; "></video> -->



            <br>

            <select id="pilihKamera" class="form-control">
            </select>
            <br>
        </div>
    </div>
</div>



<!-- <input type="text" id="hasilscan"> -->

<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->

<script>
    let selectedDeviceId = null;
    const codeReader = new ZXing.BrowserMultiFormatReader();
    const sourceSelect = $("#pilihKamera");

    $(document).on('change', '#pilihKamera', function() {
        selectedDeviceId = $(this).val();
        if (codeReader) {
            codeReader.reset()
            initScanner()
        }
    })

    function initScanner() {
        codeReader
            .listVideoInputDevices()
            .then(videoInputDevices => {
                videoInputDevices.forEach(device =>
                    console.log(`${device.label}, ${device.deviceId}`)
                );

                if (videoInputDevices.length > 0) {

                    if (selectedDeviceId == null) {
                        if (videoInputDevices.length > 1) {
                            selectedDeviceId = videoInputDevices[1].deviceId
                        } else {
                            selectedDeviceId = videoInputDevices[0].deviceId
                        }
                    }


                    if (videoInputDevices.length >= 1) {
                        sourceSelect.html('');
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option')
                            sourceOption.text = element.label
                            sourceOption.value = element.deviceId
                            if (element.deviceId == selectedDeviceId) {
                                sourceOption.selected = 'selected';
                            }
                            sourceSelect.append(sourceOption)
                        })

                    }

                    codeReader
                        .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                        .then(result => {

                            //hasil scan
                            console.log(result.text)
                            $("#hasilscan").val(result.text);

                            if (codeReader) {
                                $.ajax({
                                    url: '<?= base_url(); ?>scan/absen',
                                    type: 'POST',
                                    data: {
                                        qrcode: result.text,

                                    },
                                    error: function() {
                                        // alert(data.error);
                                        alert('gagal absen');
                                        console.log(data.error);
                                    },
                                    success: function(data) {
                                        alert(data);
                                        // console.log(data.error);

                                        codeReader.reset()
                                        initScanner()
                                    }
                                });

                            }
                        })
                        .catch(err => console.error(err));

                } else {
                    alert("Camera not found!")
                }
            })
            .catch(err => console.error(err));
    }


    if (navigator.mediaDevices) {


        initScanner()


    } else {
        alert('Cannot access camera.');
    }
</script>