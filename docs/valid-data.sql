

INSERT INTO `album` (`id`, `title`, `year`, `desc`) VALUES
(1, 'Рождество', 2011, ''),
(2, 'Жили-были', 2009, ''),
(3, 'Под аптекой', 2006, '<p>Альбом записанный группой по следам своих выступлений на Невском проспекте в городе Санкт-Петербург. Совершенно случайным образом музыканты вдруг решили собраться и поиграть на улице именно группой. К тому времени у всех нынешних участников группы уже был богатый опыт уличных выступлений, но в основном заграницей. Первый совместный опыт игры в Петербурге на улице группой оказался настолько позитивным, что с этого момента Отава ё стали регулярно выступать около гомеопатический аптеки на Невском проспекте. Отсюда и название альбома — «Под аптекой».</p>\n<p>Репертуар состоял в основном из кельтских мелодий. Практически все аранжировки были сделаны в процессе уличных концертов. Чтобы сохранить концертный дух, альбом «Под аптекой» был записан живьём на Петербургской студии грамзаписи, с небольшими дописками сделанными на студии «Часовщик».  Звук и концепция альбома получились вполне адекватными состоянию группы на тот момент.</p> \n<p>По принципиальным соображениям «Под аптекой» был издан без участия выпускающих лэйблов, то есть своими силами, в формате диджипак на деньги вырученные от уличных выстулпений. </p>\n<p class="title-em">В записи приняли участие:</p>\n<ul class="list">\n<li><span class="bold">Алексей Белкин</span> — галисийская волынка, shuttle pipe, жалейка, вокал</li>\n<li><span class="bold">Дмитрий Шихардин</span> — фиддл, вокал</li>\n<li><span class="bold">Алексей Скосырев</span> — акустическая гитара, вокал</li>\n<li><span class="bold">Наталья Высоких</span> — скрипка</li>\n<li><span class="bold">Пётр Сергеев</span> — дарбука</li>\n<li><span class="bold">Светлана Кондесюк</span> — галисийская волынка, флейта</li>\n<li><span class="bold">Роман Стансков</span> — бузуки</li>\n</ul>\n<p>К сожалению, с тех пор в нашем городе многое изменилось и музыкантам группы Отава ё больше не дают играть на улице ссылаясь на то, что это не разрешено и является незаконной коммерческой деятельностью. Так что на сегодняшний день альбом «Под аптекой» — единственное место где возможно услышать музыку уличных музыкантов в нашем городе. </p>\n');



INSERT INTO `audio` (`id`, `album_id`, `title`) VALUES
(1, 1, 'Как в Иерусалиме рано зазвонили'),
(2, 1, 'Днесь Христос родился'),
(3, 1, 'Христос Спаситель'),
(4, 1, 'На небе зорька'),
(5, 1, 'Рождество Христово, ангел прилетел'),
(6, 1, 'Небо и земля'),
(7, 1, 'Уродилась коляда'),
(8, 1, 'Запевайте, христиане'),
(9, 1, 'Эта ночь святая'),
(10, 1, 'Торжествуйте, веселитесь'),
(11, 2, 'Интро'),
(12, 2, 'Кадриль'),
(13, 2, 'Жил-был у бабушки серенький козлик'),
(14, 2, 'Про Ивана groove'),
(15, 2, 'Лезгинка'),
(16, 2, 'Гавоты'),
(17, 2, 'Про Диму и Петю'),
(18, 2, 'Во кузнице'),
(19, 2, 'Финская полька'),
(20, 2, 'Иванушка рачек'),
(21, 2, 'Риорита'),
(22, 2, 'Крутится вертится шарф голубой'),
(23, 3, 'Reels'),
(24, 3, 'Saltarella / Tarantella'),
(25, 3, 'Bailar'),
(26, 3, 'Польки / Найман'),
(27, 3, 'Джиги'),
(28, 3, 'Шведская'),
(29, 3, 'La sansonette'),
(30, 3, 'Lazersong'),
(31, 3, 'Песня'),
(32, 3, 'Хит'),
(33, 3, 'Вальс Петрова');

UPDATE `otava`.`album` SET `title` = 'Под аптекой',
`desc` = 'Наш первый альбом' WHERE `album`.`id` =3;


INSERT INTO `concert` (`id`, `date`, `title`, `link`, `place`, `time`, `cost`, `desc`) VALUES
(4, '2013-08-23', '', 'http://www.mjr.lt/arc/mjr2012/en/festival/about-festival', 'Lithuania', NULL, NULL, ''),
(5, '2013-07-10', '', 'http://virufolk.ee/', 'Estonia, Виру', NULL, NULL, ''),
(6, '2013-07-27', '', '', 'Latvia, Цесис', NULL, NULL, 'Фестиваль организованный лэйблом Lauska по поводу своего юбилея и выхода нового сборника Sviests 5 с нашим участием'),
(7, '2013-07-15', '', '', 'Austria, Mistelbach', NULL, NULL, 'Концерт в пабе'),
(8, '2013-07-13', '', 'http://www.wellenklaenge.at', 'Austria', NULL, NULL, ''),
(9, '2013-07-12', '', 'http://www.wackelsteinfestival.at', 'Austria', NULL, NULL, ''),
(10, '2013-07-10', 'Kaustinen folk festival', 'http://kaustinen.net/en/', 'Finland', NULL, NULL, ''),
(11, '2013-07-09', 'Kaustinen folk festival', 'http://kaustinen.net/en/', 'Finland', NULL, NULL, ''),
(12, '2013-06-30', 'Cекретный летний концерт', '', 'СПб, Восточная африка', NULL, NULL, ''),
(13, '2013-06-23', 'Фестиваль живой музыки "Троица - всё живое"', 'http://www.3fest.ru', 'Электроугли', NULL, 0, ''),
(14, '2013-06-22', 'Фестиваль "Солнцестояние"', 'http://www.solarfest.su/', 'Омская область, Муромский район, д. Окунёво', NULL, NULL, ''),
(15, '2013-06-21', 'Фестиваль "Солнцестояние"', 'http://www.solarfest.su/', 'Омская область, Муромский район, д. Окунёво', NULL, NULL, ''),
(16, '2013-06-08', 'Фестиваль "Puude taga on inimene"', 'http://puudetagaoninimene.ee/', 'Таллин', NULL, NULL, '');


INSERT INTO `video` (`id`, `player_code`, `desc`) VALUES
(1, '<object height="385" width="480"><param value="http://www.youtube.com/v/ps9RqYpdkX0?fs=1&amp;hl=en_US" name="movie"><param value="true" name="allowFullScreen"><param value="always" name="allowscriptaccess"><embed height="385" width="480" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/ps9RqYpdkX0?fs=1&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Эфир на канале СТО, 24го Сентября 2009 года. Авторская мелодия А. Белкина, слова народные'),
(2, '<object height="385" width="640"><param value="http://www.youtube.com/v/Ui2oKFXPHxI?fs=1&amp;hl=en_US" name="movie"><param value="true" name="allowFullScreen"><param value="always" name="allowscriptaccess"><embed height="385" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/Ui2oKFXPHxI?fs=1&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Мы сняли клип на песню "про диму и петю"!'),
(3, '<iframe height="390" frameborder="0" width="480" allowfullscreen="" src="http://www.youtube.com/embed/1A4zZmHCv8k" title="YouTube video player"></iframe>', '"Кадриль", видео с концерта'),
(4, '<object height="360" width="640">\r\n<param value="http://www.youtube.com/v/YbBU06irWT8?version=3&amp;hl=en_US" name="movie">\r\n<param value="true" name="allowFullScreen">\r\n\r\n<param value="always" name="allowscriptaccess">\r\n<embed height="360" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/YbBU06irWT8?version=3&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Новый клип "про ивана groove"'),
(5, '<object height="360" width="640"><param value="http://www.youtube.com/v/eIa7ZfJUeGU?version=3&amp;hl=en_US" name="movie">\r\n\r\n<param value="true" name="allowFullScreen">\r\n\r\n<param value="always" name="allowscriptaccess">\r\n<embed height="360" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/eIa7ZfJUeGU?version=3&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Третий официальный видеоклип фолк-группы Отава Ё, песня на стихи Даниила Хармса. Снято в марте 2012 года во дворе музея Анны Ахматовой, в Санкт-Петербурге');