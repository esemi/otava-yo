#! /usr/bin/env python
# -*- coding: utf-8 -*-

__author__ = 'esemi'

from dateutil.parser import parse as date_parser
import os
import logging
import re


CURRENT_PATH = os.path.realpath(os.path.dirname(os.path.realpath(__file__)))

SITE_RE = re.compile(u'<a href="http[s]?://(.+)">(.+)</a>(\s&lt;|<br>)', re.U | re.I)
EMAIL_RE = re.compile(u'&lt;<a href="mailto:(.+)">(.+)</a>&gt;', re.U | re.I)
AUTHOR_RE = re.compile(u'(.+)&lt;|(.+)<br>', re.U | re.I)
CITY_RE = re.compile(u'<br>(.+)\s-\s', re.U | re.I)
DATE_RE = re.compile(u'\s-\s(.+)', re.U | re.I)


def split_posts(content):
    return content.split('<center><br>* * *</center>')


def parse_post(content):

    post = dict(
        site='',
        content='',
        email='',
        author='',
        date_publish='',
        city=''
    )

    parts = content.split('</b><br>')
    if len(parts) != 2:
        raise Exception('Invalid post parts count')

    # parse content todo supporting <br> tag ?
    post['content'] = re.sub(ur'<[^>]*?>', '', parts[0]).strip()

    # parse site
    site = SITE_RE.search(parts[1].replace('<a href="http:///">', ''))
    if site is not None:
        post['site'] = site.group(1).replace('otava-yo.spb.ru/guestbook/', '').strip()

    # parse email
    email = EMAIL_RE.search(parts[1])
    if email is not None:
        post['email'] = email.group(1).strip()

    # parse author todo replace аб to Отава Ё
    author_from_site = SITE_RE.search(parts[1])
    author_from_str = AUTHOR_RE.search(parts[1])
    if author_from_site is not None:
        post['author'] = author_from_site.group(2).strip()
    elif author_from_str is not None:
        post['author'] = filter(lambda x: x is not None, list(author_from_str.groups()))[0].strip()

    # parse city
    city = CITY_RE.search(parts[1])
    if city is not None:
        post['city'] = city.group(1).strip(' ,')

    # parse date todo
    date = DATE_RE.search(parts[1])
    if date is not None:
        post['date_publish'] = date.group(1).strip()
        # todo parse date
        print post['date_publish']
        print date_parser(post['date_publish'])

    return post

if __name__ == '__main__':

    logging.basicConfig(
        format='%(asctime)s %(levelname)s:%(message)s',
        level=logging.DEBUG)

    with open(os.path.join(CURRENT_PATH, 'source.html'), "r") as content_file:
        content = content_file.read().replace('\n', '')
        logging.info('get %d content chars' % len(content))

        posts = split_posts(content)
        logging.info('parse %d posts' % len(posts))

        for num, post in enumerate(posts):
            logging.info('process %d post' % num)
            post = post.strip()

            parsed_post = parse_post(post)
            logging.info(parsed_post)

            # todo validate fields





