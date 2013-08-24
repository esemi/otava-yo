
INSERT INTO `concert` (`id`, `date`, `title`, `link`, `desc`) VALUES
(1, '2013-08-23', 'Latvia, Цесис', 'http://www.mjr.lt/arc/mjr2012/en/festival/about-festival', 'Фестиваль организованный лэйблом Lauska по поводу своего юбилея и выхода нового сборника Sviests 5 с нашим участием.'),
(2, '2013-08-12', 'Рыба в рыбе', '', 'атата и нету описания'),
(3, '2013-08-30', 'Рыбонька', 'http://www.mjr.lt/arc/mjr2012/en/festival/about-festival', 'немного описания ещё');

INSERT INTO `otava`.`album` (`id` ,`title`) VALUES (NULL , 'Тестовый альбом');

INSERT INTO `audio` (`id`, `album_id`, `title`, `media_link`) VALUES
(1, 1, 'Тестовый трек', 'd464efc8a6963167a66667e27875ff2c_1377176502.mp3');

INSERT INTO `news` (`id`, `date_publish`, `title`, `content`) VALUES
(1, '2013-05-06', 'Запись нового альбома', 'мы вышли на финишную прямую в записи нового альбома! Осталось буквально 2-3 сессии на студии и можно будет сказать, что главная часть работы сделана. После этого весь материал будет переправлен в Латвию на Рижскую студию GEM, где звукорежиссёр Гатис Гауяниекс будет заниматься сведением, после этого сведённый материал уедет в Германию, где будет сделан мастеринг. Эта схема работы нами опробована на двух предыдущих альбомах.\r\n<br><br>\r\nНовый альбом – это накопившийся материал за последние 4 года, песни всем известные и не очень. На данном альбоме мы продолжили развивать и пестовать тему рашн бит.\r\n<br><br>\r\nБудучи несвязанными никакими контрактными обязательствами – мы записывались спокойно без спешки, позволяя себе различные эксперименты. В самом ближайшем будущем выложим что-нибудь послушать. Выпуск альбома планируется на осень 2013 года. Как всегда новый альбом будет издан на компакт дисках и выложен на нашей странице на кругах.\r\n<br><br>\r\nЛето 2013 обещает быть насыщенным – есть несколько предложений от европейских фестивалей. В планах поездки в Эстонию, Латвию, Австрию и Финляндию! Финляндию хочется отметить особо, так как это будет наша первая поездка за долгие годы в Финляндию с концертами. До этого, как вы знаете, мы были там только в качестве уличных музыкантов и проездом в аэропорт. Теперь настало время возвращать долги. В июле мы выступим на одном из старейших и уважаемых фолк фестивалей - Kaustinen folk festival.\r\n<br><br>\r\nВ середине мая мы выступим в Москве в клубе Шоколадная фабрика, а 2го июня в Петербурге в клубе DaDa, тем самым закроем клубный сезон и перейдём к фестивалям. ');

INSERT INTO `otava`.`guestbook` (`id`, `author`, `date_publish`, `email`, `city`, `site`, `content`) VALUES (NULL, 'ОтаваЁ', '2013-08-22 09:12:34', 'otava@otava.ru', 'СПб', 'otava.ru', 'Внимание, внимание - ближайшее наше выступление будет на XIV международном фолк-фестивале "День Святого Патрика в СПб" - 16го марта 2013 года, в самом большом клубе города - А2 (зал МИР). Начало в 20.00. www.patrickfestival.ru '), (NULL, 'Pavel', '2013-08-23 00:20:42', '', '', '', 'Привет! Расписание на Патрик есть? кто когда играет по времени?');






