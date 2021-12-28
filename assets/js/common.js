// window.addEventListener('load', function() {
window.onload = function() {
    // $('#multi').mdbRange({
    //     width: '100%',
    //     direction: 'vertical',
    //     value: {
    //         min: 0,
    //         max: 100,
    //     },
    //     single: {
    //         active: true,
    //         value: {
    //             step: 1,
    //             symbol: ''
    //         },
    //         counting: false,
    //         countingTarget: null,
    //         bgThumbColor: '#4285F4',
    //         textThumbColor: '#fff',
    //         multi: {
    //             active: true,
    //             value: {
    //                 step: 1,
    //                 symbol: ''
    //             },
    //             counting: false,
    //             rangeLength: 2,
    //             countingTarget: null,
    //             bgThumbColor: '#4285F4',
    //             textThumbColor: '#fff'
    //         },
    //     }
    // });
};

$(document).ready(function() {

    // const web3 = new Web3('https://data-seed-prebsc-1-s1.binance.org:8545');
    // if (gaddress == undefined || gaddress == '') {
    //     $.ajax({
    //         method: "POST",
    //         url: baseUrl + 'index.php/maincontroller/connectWallet',
    //         data: { address: '' },
    //         beforeSend: function() {
    //             // $('.loading').show();
    //         },
    //         success: function(data) {
    //             //what do i fill here
    //             var button = document.querySelector('button#connect-btn');
    //             button.text = "Connect";
    //         },
    //         error: function(err) {

    //         }
    //     });
    // }

    var btn_connect = document.querySelector('button#connect-btn');
    var btn_uploadAndshare = document.querySelector('button#updateandshare');

    if (window.ethereum) {
        window.ethereum.on("accountsChanged", (accounts) => {
            if (accounts.length > 0) {
                $.ajax({
                    method: "POST",
                    url: baseUrl + 'index.php/maincontroller/connectWallet',
                    data: { address: accounts[0] },
                    dataType: 'JSON',
                    beforeSend: function() {
                        // $('.loading').show();
                    },
                    success: function(data) {
                        //what do i fill here
                        var button = document.querySelector('button#connect-btn');
                        if (!data.address && data.address == '') {
                            button.textContent = "Connect";
                        } else {
                            button.textContent = data.address;
                            gaddress = data.address;
                            setAddress(data.address);
                        }
                    },
                    error: function(err) {

                    }
                });
            } else {
                $.ajax({
                    method: "POST",
                    url: baseUrl + 'index.php/maincontroller/connectWallet',
                    data: { address: gaddress },
                    beforeSend: function() {
                        // $('.loading').show();
                    },
                    success: function(data) {
                        //what do i fill here
                        var button = document.querySelector('button#connect-btn');
                        button.textContent = "Connect";
                    },
                    error: function(err) {

                    }
                });
            }
        })
    }

    $('#connect-btn').click(async function() {

        if (window.ethereum) {
            try {
                var addressArray = await window.ethereum.request({
                    method: "eth_requestAccounts",
                });

                var obj = {
                    status: "👆🏽 Write a message in the text-field above.",
                    address: addressArray[0],
                };

                gaddress = obj.address;

                $.ajax({
                    method: "POST",
                    url: baseUrl + 'index.php/maincontroller/connectWallet',
                    data: { address: gaddress },
                    dataType: 'JSON',
                    beforeSend: function() {
                        // $('.loading').show();
                    },
                    success: function(data) {
                        //what do i fill here
                        var button = document.querySelector('button#connect-btn');
                        if (!data.address && data.address == '') {
                            button.textContent = "Connect";
                        } else {
                            setAddress(data.address);
                            button.textContent = ellipseAddress(data.address);
                        }
                    },
                    error: function(err) {

                    }
                });


                // return obj;
            } catch (err) {
                console.log("address: ,error: " + err.message);
            }
        } else {
            window.location.href("https://metamask.io/download.html");
        }

        // const web3 = new Web3(window.ethereum.currenctProvider);
        // if (typeof web3 !== 'undefined') {
        //     web3 = new Web3(web3.currentProvider);

        //     web3.eth.requestAccounts().then(() => {
        //         // alert("connected wallet!");
        //         // initialize
        //         // startApp(web3);
        //     }).catch((err) => {
        //         alert("please connect wallet! \ror you must install wallet on browser.\n\r" + err);
        //     })

        // } else {
        //     alert("No hay web3");
        //     // Warn the user that they need to get a web3 browser
        //     // Or install MetaMask, maybe with a nice graphic.
        // }
    })

    function setAddress(address) {
        $("[name='wallet-address']").val(address);
    }

    function ellipseAddress(address = '', width = 4) {
        if (!address) {
            return '';
        }

        return address.slice(0, width) + '...' + address.slice(-width);
    }

    // dropzone

    // Add restrictions

    // Dropzone.options.fileupload = {
    // acceptedFiles: 'image/*',
    // maxFilesize: 1 // MB
    // };

    var dropzoneOptions = {
        dictDefaultMessage: 'Drop Here!',
        paramName: "file",
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        autoProcessQueue: false,
        url: baseUrl + "index.php/maincontroller/dragdrop_upload",
        init: function() {
            this.on("success", function(file) {
                console.log("success > " + file.name);
                window.location = baseUrl + "index.php/cart/upload/" + last_inserted;
            });
        },
        renameFile: function(file) {
            // let newName = new Date().getTime() + '_' + file.name;
            let newName = last_inserted + '_' + gaddress + file.name;
            return newName;
        }
    };
    var uploader = document.querySelector('#my-dropzone');
    var myDropzone = new Dropzone(uploader, dropzoneOptions);

    var last_inserted = 0;

    $("#updateandshare").click(function() {

        var filelist;
        var desc = document.querySelector('textarea[name="desc"]');
        var info = document.querySelector('textarea[name="info"]');
        var price = document.querySelector('input[name="price"]');
        var wallet = document.querySelector('input[name="wallet-address"]');
        var count = document.querySelector('input[name="count"]');

        if (desc.value == '' ||
            price.value == '0' ||
            wallet.value == '') {
            alert('please input params.');
            return;
        }

        var filelist = myDropzone.getQueuedFiles();
        if (filelist.length > 0) {

        } else {
            alert('please upload file(s).');
            return;
        }

        var fileinfos = filelist.map(item => {
            return [item.name, item.size];
        })

        dataObj = {
            address: wallet.value,
            desc: desc.value,
            price: price.value,
            info: info.value,
            filelist: fileinfos,
            count: count.value
        }

        $.ajax({
            method: "POST",
            url: baseUrl + 'index.php/maincontroller/uploadandshare',
            data: dataObj,
            dataType: 'JSON',
            beforeSend: function() {
                // $('.loading').show();
            },
            success: function(data) {
                //what do i fill here
                if (data) {
                    last_inserted = data;
                    myDropzone.processQueue();
                    console.log('uploaded to database.');
                }
            },
            error: function(err) {

            }
        });
        // window.location.href = "<?php echo site_url('sale'); ?>";
    });


    /** 
     * sliding for count
     */
    var valueSpan = document.querySelector('.valueSpan');
    var slider = document.querySelector('#count');
    valueSpan.innerHTML = slider.value;
    slider.oninput = function() {
        valueSpan.innerHTML = this.value;
    }
})