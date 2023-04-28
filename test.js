setTimeout("$('.body').css('transform','translateY(0)');", 1000);
setTimeout("$('.main-desc').addClass('b-show')", 1500);
setTimeout("$('body').addClass('add-scroll')", 3000);
setTimeout("$('html').addClass('add-scroll')", 3000);

setInterval(function () {
  let user_mass = $('.users_mass');
  var user_full_info = '';
  user_mass.map((e) => {
    let full_info = user_mass[e].innerText + '/';
    user_full_info += full_info;
  });
  $('input[name=comments]').val('Алексей Живов/' + user_full_info);
}, 500);

function myMassange(userGend) {
  var h = new Date();
  var minut = ('0' + h.getMinutes()).slice(-2);
  var hours = ('0' + h.getHours()).slice(-2);
  var time = hours + ':' + minut;

  let mass =
    '<div class="chat-content-item user "><div class="chat-content-desc"><div class="chat-content-desc-item user"><p class="message-time" id="time">' +
    time +
    '</p><p class="text users_mass">' +
    userGend +
    '</p></div></div></div>';
  $('.chat-content-list').append(mass);

  $('.content').animate(
    {
      scrollTop: $('.chat-content-list').height(),
    },
    700
  );
  $('#scroll_id').addClass('hide');
}

const OFFER = '«OptiVision»';
let now = new Date();
let mm = now.getMonth() + 1;
let day = now.getDate();
let year = now.getFullYear();
let date = '' + day + '.' + mm + '.' + year + '';
const massange = [
  {
    m: 'Добрый день, я доктор Сергей Михайлович Бубновский.',
  },
  {
    m: 'Я провожу онлайн-консультации в рамках проекта “Здоровье суставов”. Этот месяц посвящен борьбе с проблемами и заболеваниями суставов и позвоночника.',
  },
  {
    m: 'Если Вас беспокоят какие либо проблемы с суставами или спиной, сегодня я провожу бесплатные консультации.',
  },
  {
    m: 'Как Вас зовут?',
  },
  {
    m: 'NAME, Очень приятно,',
  },
  {
    m: 'Какая именно проблема вас беcпокоит?',
  },
  
  {
    m: 'Какой тип боли Вы чаще всего испытываете в этой области?',
  },

  {
    m: 'Как давно у Вас стали появляться боли и дискомфорт?',
  },

  {
    m: 'Насколько активный образ жизни Вы вели до появления симптомов?',
  },
  {
    m: 'Сколько Вам лет?',
  },
  {
    m: 'NAME , благодарю Вас за ответы.',
  },
  {
    m: 'Любой нелеченый артрит с течением времени приводит к артрозу, потому что воспаление нарушает обмен веществ в хряще. Не получая достаточного питания, хрящ начинает истончаться, а затем постепенно разрушается, что в наихудшем исходе приводит даже к инвалидности!',
  },
  {
    m: 'Поэтому хорошо, что Вы обратились ко мне.',
  },
  {
    m: 'Пожалуйста, запишите, чтобы не забыть.',
  },
  {
    m: 'Чтобы суставы не болели, их нужно беречь от перегрузок. При тяжелых нагрузках, длительном пребывании в положении стоя, поднятии и переносе тяжестей на пораженные суставы действует сила, которая значительно превышает массу тела и вредит хрящу.',
  },
  {
    m: 'NAME, в Вашем случае также обязательно применение крема на основе природных экстрактов: арники, ментола, камфоры, эфирных масел сосны и других.',
  },
  {
    m: 'Данные компоненты можно приобрести и применять по отдельности. Но эффективнее и удобнее в составе нового средства FLEDOX, которое я и мои коллеги из других стран рекомендуем своим пациентам.',
  },
  {
    m: 'Согласно результатам клинических исследований, FLEDOX является наиболее эффективным на сегодняшний день средством как на ранних, так и поздних стадиях заболеваний суставов. А главное, начинает действовать уже после второго применения.',
  },
  {
    m: "Вот так он выглядит: <br><img class='center-image product-img' src='img/product.png' style='max-width: 60%;'>",
  },
  {
    m: 'А сейчас к другим хорошим новостям. Вы только что прошли онлайн-диагностику и стали моим 2000-тысячным клиентом!',
  },
  {
    m: 'И сегодня у Вас есть возможность получить FLEDOX всего за 1 €, в рамках акции завода-производителя.',
  },
  {
    m: 'Количество упаковок FLEDOX по акции ограничено, поэтому, NAME, рекомендую поспешить с заказом.',
  },
  {
    m: 'Вам перезвонит специалист и после уточнения всех деталей в тот же день Вам будет отправлена посылка с курсом средства FLEDOX.',
  },
  
];

var mass_id = 0;
var length_mass = 0;
var lengt_num_mas = 0;
var text = '';
var speedtext = 10; // скорость вывода сообщений
var process = true;
setTimeout(() => {
  var h = new Date();
  var minut = ('0' + h.getMinutes()).slice(-2);
  var hours = ('0' + h.getHours()).slice(-2);
  var time = hours + ':' + minut;

  const body_mas =
    '<div class="chat-content-item manager "><div class="chat-content-desc"><div class="chat-content-desc-item manager"><p class="message-time" id="time">' +
    time +
    '</p><p class="text" id="mass' +
    mass_id +
    '"></p></div></div></div>';
  $('.chat-content-list').append(body_mas);
  const mas_inf = setInterval(function () {
    if (process == true) {
      if (lengt_num_mas != massange.length) {
        text += massange[lengt_num_mas].m[length_mass];
        length_mass++;
        $('#mass' + lengt_num_mas + '').html(text);
        if (
          lengt_num_mas === 3 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question1();
          process = false;
          choise1();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (
          lengt_num_mas === 5 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question2();
          process = false;
          choise2();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (
          lengt_num_mas === 6 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question3();
          process = false;
          choise3();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (
          lengt_num_mas === 7 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question4();
          process = false;
          choise4();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (
          lengt_num_mas === 8 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question5();
          process = false;
          choise5();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (
          lengt_num_mas === 9 &&
          length_mass === massange[lengt_num_mas].m.length - 1
        ) {
          question6();
          process = false;
          choise6();
          $('#scroll_id').addClass('hide-q');
          $('.content').animate(
            {
              scrollTop: $('.chat-content-list').height(),
            },
            700
          );
          $('#scroll_id').removeClass('hide-q');
        }
        if (length_mass == massange[lengt_num_mas].m.length) {
          lengt_num_mas++;
          mass_id++;
          length_mass = 0;
          text = '';
          app();
          let proc_scroling = lengt_num_mas - 1;
        }
      } else {
        clearInterval(mas_inf);

        $('#mass' + lengt_num_mas + '')
          .parent()
          .parent()
          .css('display', 'none');
        $('.iframe-form').addClass('show');
      }
    } else {
    }
  }, speedtext);
}, 1000);



function app() {
  $('.content').animate(
    {
      scrollTop: $('.chat-content-list').height(),
    },
    700
  );

  var h = new Date();
  var minut = ('0' + h.getMinutes()).slice(-2);
  var hours = ('0' + h.getHours()).slice(-2);
  var time = hours + ':' + minut;

  var div = $('.chat').height() + 100;
  var win = $('.content').height();

  if (div > win) {
    $('#scroll_id').removeClass('hide');
    var i = $('.inp').val();
    $('.inp').val(++i);
  }

  const body_mas =
    '<div class="chat-content-item manager "><div class="chat-content-desc"><div class="chat-content-desc-item manager"><p class="message-time" id="time">' +
    time +
    '</p><p class="text" id="mass' +
    mass_id +
    '"></p></div></div></div>';

  $('.chat-content-list').append(body_mas);

  function inputVal() {
    $('#scroll_id').removeClass('aba');
    $('#scroll_id').removeClass('hide');
    var i = $('.inp').val();
    $('.inp').val(++i);
  }

  if (document.getElementById('res').value == '0') {
    $('#scroll_id').addClass('aba');
  } else {
    $('#scroll_id').removeClass('aba');
  }
}




//<div class="answers-name"><input type="text" class="input-name" placeholder="Введите Имя" id="user" required><br><button type="button" class="answer answer-user">Ответить</button></div>
function question1() {

    $('.chat-content-list').append(
      '<div class="chat-content-buttons-gender done1"><div class="chat-content-buttons-gender-block"><div class="answers-name"><input type="text" class="input-name" placeholder="Введите Имя" id="user" value=""><br><button type="button" class="answer answer-user">Ответить</button></div></div></div>'
    );
  }

  function choise1() {

    $('.answer-user').click(() => {
      document.querySelector('.chat-content-buttons-gender').style.display =
        'none';
      document
        .querySelector('.chat-content-buttons-gender')
        .classList.remove('done1');
      myMassange('');
      setTimeout(() => {
        process = true;
      }, 500);
    });
    // $('.question1W').click(() => {
    //   document.querySelector('.chat-content-buttons-gender').style.display =
    //     'none';
    //   document
    //     .querySelector('.chat-content-buttons-gender')
    //     .classList.remove('done1');
    //   myMassange('31-40 lat');
    //   setTimeout(() => {
    //     process = true;
    //   }, 500);
    // });
    // $('.question1P').click(() => {
    //   document.querySelector('.chat-content-buttons-gender').style.display =
    //     'none';
    //   document
    //     .querySelector('.chat-content-buttons-gender')
    //     .classList.remove('done1');
    //   myMassange('41-50 lat');
    //   setTimeout(() => {
    //     process = true;
    //   }, 500);
    // });
    // $('.question1K').click(() => {
    //   document.querySelector('.chat-content-buttons-gender').style.display =
    //     'none';
    //   document
    //     .querySelector('.chat-content-buttons-gender')
    //     .classList.remove('done1');
    //   myMassange('51-60 lat');
    //   setTimeout(() => {
    //     process = true;
    //   }, 500);
    // });
    // $('.question1T').click(() => {
    //   document.querySelector('.chat-content-buttons-gender').style.display =
    //     'none';
    //   document
    //     .querySelector('.chat-content-buttons-gender')
    //     .classList.remove('done1');
    //   myMassange('Powyżej 60 lat');
    //   setTimeout(() => {
    //     process = true;
    //   }, 500);
    // });
  }
function question2() {
  $('.chat-content-list').append(
    '<div class="chat-content-buttons-gender done2"><div class="chat-content-buttons-gender-block"><span class="question2M">боли в суставах нижних конечностей</span></div ><div class="chat-content-buttons-gender-block"><span class="question2W">боли в суставах верхних конечностей</span></div><div class="chat-content-buttons-gender-block" ><span class="question2P">боли в спине, пояснице и шее</span></div></div>'
  );
}

function choise2() {
  $('.question2M').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done2').classList.remove('done2');
    myMassange('боли в суставах нижних конечностей');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question2W').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done2').classList.remove('done2');
    myMassange('боли в суставах верхних конечностей');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question2P').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done2').classList.remove('done2');
    myMassange('боли в спине, пояснице и шее');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
}

function question3() {
  $('.chat-content-list').append(
    '<div class="chat-content-buttons-gender done3"><div class="chat-content-buttons-gender-block"><span class="question3M">Ноющие — беспокоят после физической нагрузки и стихают в покое</span></div><div class="chat-content-buttons-gender-block"><span class="question3W">«Ночные» — свидетельствует о выраженном поражении сустава и связаны с застоем крови</span></div><div class="chat-content-buttons-gender-block"><span class="question3P">Постоянные — являются признаком воспалительного процесса в суставной сумке</span></div><div class="chat-content-buttons-gender-block"><span class="question3K">Внезапные— связаны с ущемлением фрагмента кости или хряща, который застрял между двумя суставными поверхностями</span></div></div>'
  );
}

function choise3() {
  $('.question3M').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done3').classList.remove('done3');
    myMassange('Ноющие — беспокоят после физической нагрузки и стихают в покое');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question3W').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done3').classList.remove('done3');
    myMassange('«Ночные» — свидетельствует о выраженном поражении сустава и связаны с застоем крови');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question3P').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done3').classList.remove('done3');
    myMassange('Постоянные — являются признаком воспалительного процесса в суставной сумке');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question3K').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done3').classList.remove('done3');
    myMassange('>Внезапные— связаны с ущемлением фрагмента кости или хряща, который застрял между двумя суставными поверхностями');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
}

function question4() {
  $('.chat-content-list').append(
    '<div class="chat-content-buttons-gender done4"><div class="chat-content-buttons-gender-block"><span class="question4M">Меньше 6 месяцев</span></div> <div class="chat-content-buttons-gender-block"><span class="question4W">1 год </span></div><div class="chat-content-buttons-gender-block"><span class="question4P">Более 1 года</span></div></div>'
  );
}

function choise4() {
  $('.question4M').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done4').classList.remove('done4');
    myMassange('Меньше 6 месяцев');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question4W').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done4').classList.remove('done4');
    myMassange('1 год ');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
  $('.question4P').click(() => {
    document.querySelector('.chat-content-buttons-gender').style.display =
      'none';
    document.querySelector('.done4').classList.remove('done4');
    myMassange('более 1 года');
    $('.chat-content-buttons-gender').css('display', 'none');
    setTimeout(() => {
      process = true;
    }, 500);
  });
}

$('.content').scroll(function () {
  if (document.getElementById('res').value == '0') {
    $('#scroll_id').addClass('aba');
  } else {
    $('#scroll_id').removeClass('aba');
  }
});

/* Скролл к якорю */
$('[data-scroll]').on('click', function (event) {
  $('.content').animate(
    {
      scrollTop: $('.chat-content-list').height(),
    },
    700
  );
  $('#scroll_id').addClass('hide');
});

/* Скрыть/показать кнопку скролла */
var $marker = $('#down-box');
$('.content').scroll(function () {
  if (
    $('.content').scrollTop() + $('.content').height() >=
    $('.chat-content-list').height() + 100
  ) {
    document.getElementById('res').value = '0';
    $('#scroll_id').addClass('hide');
  } else {
    $('#scroll_id').removeClass('hide');
  }
});

if (document.querySelector('#scroll_id')) {
  let scrollProc = false;
  setInterval(scrollMy, 1);

  function scrollMy() {
    if (!document.querySelector('#order_form').classList.contains('show')) {
      if (
        document.querySelector('.done1') ||
        document.querySelector('.done2') ||
        document.querySelector('.done3') ||
        document.querySelector('.done4') ||
        document.querySelector('.done5') ||
        document.querySelector('.done6')
      ) {
        return scrollProc;
      } else {
        $('.content').animate(
          {
            scrollTop: $('.chat-content-list').height(),
          },
          -700
        );
      }
    }
  }
}
