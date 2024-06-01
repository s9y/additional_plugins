document.addEventListener("DOMContentLoaded", function(event) {
    var lk = document.getElementById("serendipity_licence_key").value;
    var server_name = window.location.hostname;

    const inpElem = document.querySelector('#serendipity_licence_key');
    const inpElem2 = document.querySelector('.grouped');
    const wrapper = document.createElement('div');
    const err_msg_wrapper = document.createElement('div');
    const err_msg = document.createElement('div');
    const msg = document.createElement('div');
    //const upgrade_msg = document.createElement('span');
    inpElem.style.maxWidth = 'none';
    inpElem.style.width = '96%';
    wrapper.style.display = 'flex';
    wrapper.style.flexDirection = 'column';
    msg.innerText = '<span>Where would you like to place the accessibility icon on your site?</span>';
    err_msg_wrapper.innerHTML = '<span id="license_key_msg" class="">\n' +
        '                        Please <a href="https://www.skynettechnologies.com/add-ons/cart/?add-to-cart=116&amp;variation_id=117&amp;quantity=1&amp;utm_source=localhost=&amp;utm_medium=vtiger-module&amp;utm_campaign=purchase-plan" target="_blank" style="color:blue">Upgrade</a>\n' +
        '                        to full version of All in One Accessibility Pro.</span>';
    err_msg.innerHTML = '<span style="display: block; color: red">Key is Invalid!</span>';
    async function licenseKey() {

        var formdata = new FormData();
        formdata.append("token", lk);
        formdata.append("SERVER_NAME", server_name);

        var requestOptions = {
            method: 'POST',
            body: formdata,
        };
        let response_v = await fetch("https://www.skynettechnologies.com/add-ons/license-api.php", requestOptions)
        return await response_v.json();
    }
    licenseKey().then(function (locale) {
        license_key_valid = locale.valid;
        if (license_key_valid == 1) {
            inpElem.style.maxWidth = 'none';
            inpElem.style.width = '48%';
            document.querySelector('#serendipity_icon_type').parentElement.parentElement.style.display = '';
            document.querySelector('#serendipity_icon_size').parentElement.parentElement.style.display = '';

        } else if (license_key_valid == 0 && inpElem.value === '') {
            inpElem.parentElement.append(wrapper);
            wrapper.append(inpElem);
            wrapper.append(err_msg_wrapper);
            document.querySelector('#serendipity_icon_type').parentElement.parentElement.style.display = 'none';
            document.querySelector('#serendipity_icon_size').parentElement.parentElement.style.display = 'none';
        }
        else {
            inpElem.parentElement.append(wrapper);
            wrapper.append(inpElem);
            wrapper.append(err_msg);
            wrapper.append(err_msg_wrapper);
            document.querySelector('#serendipity_icon_type').parentElement.parentElement.style.display = 'none';
            document.querySelector('#serendipity_icon_size').parentElement.parentElement.style.display = 'none';
        }
    })
});
