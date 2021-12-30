const contractAddress = "0x63261a0ACc9dc844D288acF27dc706C60940B70f";

let userLoginData = {
    state: "loggedOut",
    ethAddress: "",
    buttonText: "Connect",
}

const cartpageId = 1
const salepageId = 0

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

// loading
var loading = document.querySelector('#loading');

function showLoading() {
    loading.style.visibility = 'visible';
}

function hiddenLoading() {
    loading.style.visibility = 'hidden';
}

// Show current button text
function showButtonText() {
    document.getElementById('connect-btn').innerHTML = userLoginData.buttonText;
}

async function onBuyNFT() {
    let tokenId = document.querySelector("input[name='tokenId']");
    var dbId = document.querySelector('input[name="dbId"]');
    showLoading();
    let res = await isPurchased(tokenId.value, userLoginData.ethAddress);
    console.log(res);
    if (res.success) {
        if (res.status) {
            alert('You already bought this NFT.');
            return;
        }
    }

    res = await getAssetInfo(tokenId.value);
    if (!res.success)
        alert(res.status);

    res = await buyNFT(tokenId.value, res.status.bnbVal);

    hiddenLoading();
    if (res.success) {

        const link = document.createElement('a');
        link.href = baseUrl + 'index.php/sale/download/' + dbId.value;
        link.click();

    } else {
        alert(res.status);
    }
}

async function onDownload() {
    var tokenId = document.querySelector('input[name="tokenId"]');
    var dbId = document.querySelector('input[name="dbId"]');

    let res = await isPurchased(tokenId.value, userLoginData.ethAddress);
    // console.log(res);

    if (res.success) {
        // res.status = true;
        if (res.status) {

            const link = document.createElement('a');
            link.href = baseUrl + 'index.php/sale/download/' + dbId.value;
            link.click();
        } else {
            alert('please buy NFT.');
        }
    } else {
        alert(res.status);
    }
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
        url: baseUrl + 'index.php/MainController/connectWallet',
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

const getBNBDecimals = () => {
    return 18;
}

function isWalletConnected() {
    if (provider !== null && provider !== undefined) return true;
    return false;
}

const disconnectWallet = async() => {
    //console.log("IsConneted: ", isWalletConnected())
    //console.log("provider: ", provider)
    await web3ModalProv.clearCachedProvider()
    if (provider && provider.disconnect && typeof provider.disconnect === 'function') {
        await provider.disconnect()
    }
    provider = null
}

const onSetFee = async() => {
    let setfee = document.querySelector("input[name='setfee']");
    if (!setfee.value) {
        alert('please enter the value.');
        return;
    }

    let res = await setFee(setfee.value);
    if (res.success) {
        alert('success');
    } else {
        alert('failed');
    }
}

const onTransferOwnership = async() => {
    let address = document.querySelector("input[name='address']");
    if (!address.value) {
        alert('please enter the address.');
        return;
    }

    let res = await transferOwnership(address.value);
    if (res.success) {
        alert('success');
    } else {
        alert('failed');
    }
}

const onWithdraw = async() => {

    let res = await withdraw();
    if (res.success) {
        alert('success');
    } else {
        alert('failed');
    }
}

const buyNFT = async(tokenId, bnbVal) => {
    if (!provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }
    const web3 = new Web3(provider);
    let contract = await new web3.eth.Contract(abi, contractAddress);
    try {
        bnbVal = web3.utils.toWei("" + bnbVal);
        await contract.methods.buyNFT(tokenId).send({ from: userLoginData.ethAddress, value: bnbVal });
        return {
            success: true,
        }
    } catch (err) {
        return {
            success: false,
            status: err.message
        }
    }
}

const getAssetInfo = async(tokenId) => {
    const web3 = new Web3(window.ethereum);
    // const web3 = new Web3('https://data-seed-prebsc-1-s1.binance.org:8545');
    let contract = await new web3.eth.Contract(abi, contractAddress);

    try {
        let data = {
            count: 0,
            limit: 0,
            bnbVal: 0,
            dbId: 0,
            tokenId: tokenId
        };
        console.log("getAssetInfo, tokenId = ", tokenId)
        console.log("getAssetInfo, before TokenCount");
        let res = await contract.methods.tokenInfoOf(tokenId).call();
        console.log("getAssetInfo, [tokencount]res = ", res)

        data.count = res[0]; // parseInt(res);
        data.limit = res[1];
        //data.bnbVal = res[2]; // / (Math.pow(10, getBNBDecimals()));
        data.bnbVal = web3.utils.fromWei(""+res[2]);
        data.dbId = res[4]
        return {
            success: true,
            status: data
        }
    } catch (err) {
        console.log("getAssetInfo: err=", err)
        return {
            success: false,
            status: err.message
        }
    }
}

const setFee = async(fee) => {

    if (!provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }

    const web3 = new Web3(provider);
    let contract = await new web3.eth.Contract(abi, contractAddress);

    try {
        await contract.methods.setTaxFee(setfee).call()
        return {
            success: true
        }
    } catch (err) {
        return {
            success: false,
            status: err.message
        }
    }
}

const getTaxFee = async() => {

    const web3 = new Web3(window.ethereum);
    let contract = await new web3.eth.Contract(abi, contractAddress);
    try {
        let res = await contract.methods.getTaxFee().call()
        return {
            success: true,
            status: res
        }
    } catch (err) {
        return {
            success: false,
            status: err.message
        }
    }
}

const transferOwnership = async() => {
    let address = document.querySelector("input[name='address']");
    if (!provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }

    const web3 = new Web3(provider);
    let contract = await new web3.eth.Contract(abi, contractAddress);
    try {
        await contract.methods.transferOwnership(address).call()
        return {
            success: true
        }
    } catch (err) {
        //console.log("err: ", err.toString())
        return {
            success: false,
            status: err.message
        }
    }
}

const withdraw = async() => {
    if (!provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }
    const web3 = new Web3(provider);
    let contract = await new web3.eth.Contract(abi, contractAddress)
    try {
        await contract.methods.withdraw().send();
        return {
            success: true,
        }
    } catch (err) {
        return {
            success: false,
            status: err.message
        }
    }
}

const isPurchased = async(tokenId, owner) => {
    if (!provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }
    const web3 = new Web3(provider);
    let contract = await new web3.eth.Contract(abi, contractAddress)
    try {
        let res = await contract.methods.isPurchased(tokenId, owner).call()
        return {
            success: true,
            status: res
        }
    } catch (err) {
        //console.log("err: ", err.toString())
        return {
            success: false,
            status: err.message
        }
    }
}

async function onMintNFT(address, price, count, last_inserted) {
    if (userLoginData.state == "loggedIn" && !provider)
        return {
            success: false,
            status: 'Connect to Wallet'
        }

    const web3 = new Web3(provider);
    let contract = new web3.eth.Contract(abi, contractAddress)

    try {
        let totalPrice = web3.utils.toWei(""+price)
        let res = await contract.methods.mintNFT(address, totalPrice, count, last_inserted).send({ from: address });
        let tokenId = res.events.MintNewToken.returnValues['tokenId']
        return {
            success: true,
            status: tokenId
        }
    } catch (err) {
        return {
            success: false,
            status: err.message
        }
    }

    /*
let contract = new window.web3.eth.Contract(abi, contractAddress);
contract.methods.mintNFT(userLoginData.ethAddress, price.value, count.value, last_inserted.toString()).send({ from: userLoginData.ethAddress })
.on('transactionHash', function (hash) {
console.log(hash);
})
.on('confirmation', function (confirmationNumber, receipt) {
console.log(receipt);
})
.on('receipt', function (receipt) {
// receipt example
console.log(receipt);
})
.on('error', function (error, receipt) { // If the transaction was rejected by the network with a receipt, the second parameter will be the receipt.
console.log(error);
});
*/
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