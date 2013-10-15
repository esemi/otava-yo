#! /usr/bin/env python
# -*- coding: utf-8 -*-

__author__ = 'esemi'

import os
import logging
import re


CURRENT_PATH = os.path.realpath(os.path.dirname(os.path.realpath(__file__)))

AUTHOR_RE = re.compile(u'</b><br><a href="http://(.*)">(.+)</a>', re.U | re.I)
SITE_RE = re.compile(u'</b><br><a href="http://(.+)/">', re.U | re.I)


def split_posts(content):
    return content.split('<center><br>* * *</center>')


def parse_post(content):

    post = dict(
        author='',
        date_publish='',
        email='',
        city='',
        site='',
        content=''
    )

    parts = content.split('</b><br>')
    if len(parts) != 2:
        raise Exception('Invalid post parts count')

    # parse content @TODO supporting <br> tag ?
    post['content'] = re.sub(ur'<[^>]*?>', '', parts[0])

    # parse author


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
            logging.debug(post)
            logging.debug(parse_post(post)['content'])





