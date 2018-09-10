FROM rabbitmq:3.7

ENV AMQPLIB_VERSION 2.7.2

RUN rabbitmq-plugins enable --offline rabbitmq_management


RUN apt-get update \
    && curl -L -o /tmp/rabbitmq-c.tar.gz /User/Mac/dnmp/rabbitmq-c/rabbitmq-c-0.8.0.tar \
    && tar xfz /tmp/rabbitmq-c.tar.gz \
    && rm -r /tmp/rabbitmq-c.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv rabbitmq-c-0.8.0 /usr/src/php/ext/rabbitmq-c \
    && docker-php-ext-install rabbitmq-c \
    && curl -L -o /tmp/amqp.tar.gz /User/Mac/dnmp/rabbitmq/amqp-1.9.3.tar \
    && tar xfz /tmp/amqp.tar.gz \
    && rm -r /tmp/amqp.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv amqp-1.9.3 /usr/src/php/ext/rabbitmq \
    && docker-php-ext-install rabbitmq \
    && rm -rf /usr/src/php


# extract "rabbitmqadmin" from inside the "rabbitmq_management-X.Y.Z.ez" plugin zipfile
# see https://github.com/docker-library/rabbitmq/issues/207
RUN set -eux; \
	erl -noinput -eval ' \
		{ ok, AdminBin } = zip:foldl(fun(FileInArchive, GetInfo, GetBin, Acc) -> \
			case Acc of \
				"" -> \
					case lists:suffix("/rabbitmqadmin", FileInArchive) of \
						true -> GetBin(); \
						false -> Acc \
					end; \
				_ -> Acc \
			end \
		end, "", init:get_plain_arguments()), \
		io:format("~s", [ AdminBin ]), \
		init:stop(). \
	' -- /plugins/rabbitmq_management-*.ez > /usr/local/bin/rabbitmqadmin; \
	[ -s /usr/local/bin/rabbitmqadmin ]; \
	chmod +x /usr/local/bin/rabbitmqadmin; \
	apt-get update; \
	apt-get install -y --no-install-recommends python; \
	rm -rf /var/lib/apt/lists/*; \
	rabbitmqadmin --version

EXPOSE 15671 15672
