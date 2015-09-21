#!/bin/bash

cd ../../

svn info $(svn status | grep S | cut -c8-) | grep URL