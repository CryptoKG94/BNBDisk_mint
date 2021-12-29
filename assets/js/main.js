const contractAddress = "0x63261a0ACc9dc844D288acF27dc706C60940B70f";

let userLoginData = {
    state: "loggedOut",
    ethAddress: "",
    buttonText: "Connect",
}

if (typeof(backendPath) == 'undefined') {
    var backendPath = '';
}


// https://medium.com/valist/how-to-connect-web3-js-to-metamask-in-2020-fee2b2edf58a
const ethEnabled = async() => {
    if (window.ethereum) {
        await window.ethereum.send('eth_requestAccounts');
        window.web3 = new Web3(window.ethereum);
        // return true;
        ethInit();
    }
    return false;
}

function ethInit() {
    ethereum.on('accountsChanged', (_chainId) => ethNetworkUpdate());

    async function ethNetworkUpdate() {
        let accountsOnEnable = await web3.eth.getAccounts();
        let address = accountsOnEnable[0];
        address = address.toLowerCase();
        if (userLoginData.ethAddress != address) {
            userLoginData.ethAddress = address;
            if (userLoginData.state == "loggedIn") {
                userLoginData.state = "loggedOut";
                userLoginData.buttonText = "Connect";
            }
        }
        if (userLoginData.ethAddress != null && userLoginData.state == "needLogInToMetaMask") {
            userLoginData.state = "loggedOut";
        }
    }
}

// Show current toast
function showMsg(id) {
    //
}

// Show current button text
function showButtonText() {
    document.getElementById('connect-btn').innerHTML = userLoginData.buttonText;
}


async function userLoginOut() {
    if (userLoginData.state == "loggedOut" || userLoginData.state == "needMetamask") {
        await onConnectLoadWeb3Modal();
    }
    if (web3ModalProv) {
        window.web3 = web3ModalProv;
        try {
            userLogin();
        } catch (error) {
            console.log(error);
            userLoginData.state = 'needLogInToMetaMask';
            showMsg(userLoginData.state);
            return;
        }
    } else {
        userLoginData.state = 'needMetamask';
        return;
    }
}


async function userLogin() {
    if (userLoginData.state == "loggedIn") {
        userLoginData.state = "loggedOut";
        userLoginData.buttonText = "Connect";
        showButtonText();
        return;
    }

    if (typeof window.web3 === "undefined") {
        userLoginData.state = "needMetamask";
        showMsg(userLoginData.state);
        return;
    }
    let accountsOnEnable = await web3.eth.getAccounts();
    let address = accountsOnEnable[0];

    if (address == null) {
        userLoginData.state = "needLogInToMetaMask";
        showMsg(userLoginData.state);
        return;
    }

    address = address.toLowerCase();
    userLoginData.state = "signTheMessage";
    showMsg(userLoginData.state);

    $.ajax({
        method: "POST",
        url: baseUrl + 'index.php/maincontroller/connectWallet',
        data: { address: address },
        dataType: 'JSON',
        beforeSend: function() {
            // $('.loading').show();
        },
        success: function(data) {
            //what do i fill here

            userLoginData.state = "loggedIn";
            showMsg(userLoginData.state);
            userLoginData.buttonText = ellipseAddress(address);
            showButtonText();
            userLoginData.ethAddress = address;
            setAddress(address);

            // Clear Web3 wallets data for logout
            localStorage.clear();
        },
        error: function(err) {

        }
    });
}

function onTransferOwnership() {

}

function onSetFee() {

}

function onWithdraw() {

}

function setAddress(address) {
    $("[name='wallet-address']").val(address);
    $("[name='toaddress']").val(address);
}

function ellipseAddress(address = '', width = 4) {
    if (!address) {
        return '';
    }

    return address.slice(0, width) + '...' + address.slice(-width);
}