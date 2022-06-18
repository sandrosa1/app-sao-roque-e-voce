import React, {useState, useRef, useEffect} from 'react';
import {
  StyleSheet,
  Text,
  View,
  Animated,
  Image,
  TouchableOpacity,
  FlatList,
  TextInput,
  ActivityIndicator,
} from 'react-native';
import NavPages from '../../componentes/NavPages';
import BuscarBar from '../../componentes/BuscarBar';
import MenuPages from '../../componentes/MenuPages';
import CardServicos from '../../componentes/CardServicos';
import {useIsFocused} from '@react-navigation/native';
import axios from 'axios';

export default function App({route}) {
  const url = 'http://www.racsstudios.com/api/v1';
  const [dados, setDados] = useState([]);
  const [loading, setLoading] = useState(false);
  const [additem, setAdditem] = useState(3);
  const [filtro, setFiltro] = useState(dados);
  const [filtro2, setFiltro2] = useState(filtro);
  const [filtro3, setFiltro3] = useState(filtro2);
  const [busca, setBusca] = useState('');
  const [mostrarx, setMostrarx] = useState(false);
  const [mostrarbusca, setMostrarbusca] = useState(false);
  const [mostrarLoading, setMostrarLoading] = useState(false);
  const [mostrarLoading2, setMostrarLoading2] = useState(false);
  const [ordenado, setOrdenado] = useState(false);
  const [imghospital, setImghospital] = useState(require('../../images/servicos/hospital0.png'));
  const [imgmecanico, setImgmecanico] = useState(require('../../images/servicos/mecanico0.png'));
  const [imgbanco, setImgbanco] = useState(require('../../images/servicos/banco0.png'));
  const [imgfarmacia, setImgfarmacia] = useState(require('../../images/servicos/farmacia0.png'));
  const [imgoutros, setImgoutros] = useState(require('../../images/servicos/outros0.png'));
  const input = useRef();
  const scrollRef = useRef();
  const scrollY = new Animated.Value(0);
  const diffClamp = Animated.diffClamp(scrollY, 0, 120);
  const translate = diffClamp.interpolate({
    inputRange: [0, 120, 240],
    outputRange: [0, -120, -240],
  });

  let icon = route.params?.icon;
  let tipo = route.params?.tipo;
  let pesquisa = route.params?.pesquisa;
  let buscaSug = 'servicos';

  useEffect(() => {
    loadApi();
  }, []);

  async function loadApi() {
    if (loading) return;
    setLoading(true);
    const response = await axios.get(`${url}/allapps`);
    setTimeout(() => setDados(response.data.apps), 300);
    setTimeout(() => {
      setLoading(false);
    }, 500);
  }

  useEffect(() => {
    setFiltro(
      dados.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  }, [dados]);

  useEffect(() => {
    setFiltro2(
      filtro.filter(item => {
        if (item.segmento == buscaSug) {
          return true;
        }
      }),
    );
  }, [filtro]);

  useEffect(() => {
    setLoading(true);
    setTimeout(() => {
      setLoading(false);
      setFiltro3(
        filtro2.filter((item, indice) => {
          if (item.segmento == buscaSug && indice < additem) {
            return true;
          }
        }),
      );
    }, 10);
  }, [filtro2, additem]);

  const buscar = () => {
    setOrdenado(false);
    setTimeout(() => {
      setMostrarLoading(false);
    }, 1000);
    if (busca == '') {
      setFiltro(dados);
    } else {
      setMostrarbusca(true);
      setFiltro2(
        filtro.filter(item => {
          if (
            item.nomeFantasia.toLowerCase().indexOf(busca.toLowerCase()) > -1 ||
            (item.chaves.toLowerCase().indexOf(busca.toLowerCase()) > -1 &&
              item.segmento == buscaSug)
          ) {
            return true;
          } else {
            return false;
          }
        }),
      );
    }
  };

  const limpaBusca = () => {
    setFiltro(dados);
  };

  function mudaricone(tipo){
      if(tipo == 'hospital'){
          setImghospital(require('../../images/servicos/hospital1.png'));
          setImgmecanico(require('../../images/servicos/mecanico0.png'));
          setImgbanco(require('../../images/servicos/banco0.png'));
          setImgfarmacia(require('../../images/servicos/farmacia0.png'));
          setImgoutros(require('../../images/servicos/outros0.png'));
      }
      if(tipo == 'oficinas'){
        setImghospital(require('../../images/servicos/hospital0.png'));
        setImgmecanico(require('../../images/servicos/mecanico1.png'));
        setImgbanco(require('../../images/servicos/banco0.png'));
        setImgfarmacia(require('../../images/servicos/farmacia0.png'));
        setImgoutros(require('../../images/servicos/outros0.png'));
    }
      if(tipo == 'bancos'){
        setImghospital(require('../../images/servicos/hospital0.png'));
        setImgmecanico(require('../../images/servicos/mecanico0.png'));
        setImgbanco(require('../../images/servicos/banco1.png'));
        setImgfarmacia(require('../../images/servicos/farmacia0.png'));
        setImgoutros(require('../../images/servicos/outros0.png'));
    }
      if(tipo == 'Drogaria/Farmácia '){
        setImghospital(require('../../images/servicos/hospital0.png'));
        setImgmecanico(require('../../images/servicos/mecanico0.png'));
        setImgbanco(require('../../images/servicos/banco0.png'));
        setImgfarmacia(require('../../images/servicos/farmacia1.png'));
        setImgoutros(require('../../images/servicos/outros0.png'));
    }
      if(tipo == 'outros'){
        setImghospital(require('../../images/servicos/hospital0.png'));
        setImgmecanico(require('../../images/servicos/mecanico0.png'));
        setImgbanco(require('../../images/servicos/banco0.png'));
        setImgfarmacia(require('../../images/servicos/farmacia0.png'));
        setImgoutros(require('../../images/servicos/outros1.png'));
    }
  }

  const filtros = tipo => {
    mudaricone(tipo);
    setMostrarbusca(false);
    setBusca();
    setMostrarx(false);
    setMostrarLoading2(true);
    setFiltro2(
      filtro.filter(item => {
        if (item.tipo == tipo) {
          return true;
        }
      }),
    );
    setOrdenado(tipo.toUpperCase());
    setAdditem(3);
    setTimeout(() => {
      setMostrarLoading2(false);
    }, 1000);
  };

  return (
    <View style={estilos.container}>
      <Animated.View
        style={{
          position: 'absolute',
          zIndex: 9,
          backgroundColor: '#f3f3f3',
          top: 0,
          transform: [{translateY: translate}],
        }}>
        <NavPages
          icon={require('../../images/menubar/servico.png')}
          title={'Serviços'}
        />
        <View
          style={{
            paddingHorizontal: 40,
            marginTop:10,
            flexDirection: 'row',
            alignItems: 'center',
          }}>
          <View style={estilos.containerBusca}>
            <TextInput
              ref={input}
              onSubmitEditing={() => {
                buscar();
                setMostrarx(true);
              }}
              value={busca}
              onChangeText={value => {
                setBusca(value);
                setMostrarbusca(false);
              }}
              placeholder={`O que voce procura em serviços?`}
              placeholderTextColor={'#8E8E8E'}
              style={estilos.input}></TextInput>
          </View>
          <TouchableOpacity
            onPress={() => {
              buscar();
              input.current.blur();
              if (busca) setMostrarx(true);
              setMostrarLoading(false);
              setTimeout(() => {
                setMostrarLoading(true);
              }, 1500);
            }}
            style={{
              position: 'absolute',
              alignSelf: 'center',
              right: 50,
              padding: 10,
            }}>
            <Image
              style={estilos.imgLupa}
              source={require('../../images/buscar.png')}
            />
          </TouchableOpacity>
          {mostrarx && (
            <TouchableOpacity
              onPress={() => {
                setMostrarbusca(false);
                limpaBusca();
                setBusca('');
                input.current.blur();
                setMostrarx(false);
              }}
              style={{
                position: 'absolute',
                alignSelf: 'center',
                left: 40,
                padding: 10,
              }}>
              <Image
                style={estilos.img2}
                source={require('../../images/close.png')}
              />
            </TouchableOpacity>
          )}
        </View>

        <View
          style={{
            flexDirection: 'row',
            alignItems: 'center',
            justifyContent: 'space-evenly',
            paddingTop: 30,
          }}>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              filtros('hospital');
              scrollRef.current.scrollToOffset({
                offset:0,
                animated: true,
              });
            }}>
            <Image
              style={estilos.imgMenu}
              source={imghospital}
            />
            <Text style={estilos.txtMenu}>Hospitais</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              filtros('oficinas');
              scrollRef.current.scrollToOffset({
                offset:0,
                animated: true,
              });
            }}>
            <Image
              style={estilos.imgMenu}
              source={imgmecanico}
            />
            <Text style={estilos.txtMenu}>Mecânicos</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              filtros('bancos');
              scrollRef.current.scrollToOffset({
                offset:0,
                animated: true,
              });
            }}>
            <Image
              style={estilos.imgMenu}
              source={imgbanco}
            />
            <Text style={estilos.txtMenu}>Bancos</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              filtros('Drogaria/Farmácia ');
              scrollRef.current.scrollToOffset({
                offset:0,
                animated: true,
              });
            }}>
            <Image
              style={estilos.imgMenu}
              source={imgfarmacia}
            />
            <Text style={estilos.txtMenu}>Farmácias</Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={estilos.containerIcon}
            onPress={() => {
              filtros('outros');
              scrollRef.current.scrollToOffset({
                offset:0,
                animated: true,
              });
            }}>
            <Image
              style={estilos.imgMenu}
              source={imgoutros}
            />
            <Text style={estilos.txtMenu}>Outros</Text>
          </TouchableOpacity>
        </View>

        <Image
          source={require('../../images/line.png')}
          style={{
            alignSelf: 'center',
            resizeMode: 'contain',
            marginTop: 10,
          }}
        />
      </Animated.View>
      <View
        style={{
          flex: 1,
        }}>
        <FlatList
          scrollEventThrottle={16}
          onScroll={Animated.event(
            [
              {
                nativeEvent: {
                  contentOffset: {y: scrollY},
                },
              },
            ],
            {useNativeDriver: false},
          )}
          ref={scrollRef}
          data={filtro3}
          keyExtractor={item => String(item.idApp)}
          renderItem={({item}) => <CardServicos dados={item} />}
          showsVerticalScrollIndicator={false}
          ListHeaderComponent={
            <>
              <View style={{marginHorizontal: 35, marginTop: 10}}>
                <View style={{height: 230}}></View>
                {ordenado ? (
                  <View style={{flexDirection: 'row', height: 25}}>
                    <Text
                      style={[estilos.txt, {textAlign: 'left', fontSize: 15}]}>
                      Ordenado por{' '}
                    </Text>
                    <Text
                      style={[
                        estilos.txt,
                        {textAlign: 'left', fontSize: 16, fontWeight: 'bold'},
                      ]}>
                      {ordenado}
                    </Text>
                  </View>
                ) : (
                  <View></View>
                )}
                {mostrarbusca && (
                  <View>
                    <Text style={[estilos.h1, {fontSize: 22}]}>Busca</Text>
                    <View style={{flexDirection: 'row'}}>
                      <Text style={estilos.txt}>Resultado de busca para </Text>
                      <Text
                        style={[
                          estilos.txt,
                          {fontFamily: 'Poppins-Bold', color: '#000'},
                        ]}>
                        {busca?.toUpperCase()}:
                      </Text>
                    </View>
                  </View>
                )}
                {!mostrarbusca && !ordenado && (
                  <View>
                    <Text style={estilos.h1}>Destaques</Text>
                    <Text style={estilos.txt}>Em dúvida para onde ir?</Text>
                    <Text style={estilos.txt}>
                      Conheça nossas dicas para a semana.
                    </Text>
                  </View>
                )}
              </View>
              {mostrarLoading2 && (
                <View
                  style={{
                    marginTop: 150,
                    marginBottom: 1000,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              )}
            </>
          }
          ListEmptyComponent={
            <>
              {!mostrarLoading ? (
                <View
                  style={{
                    marginTop: 150,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={50} color="#910046" />
                </View>
              ) : (
                <View>
                  <View style={{marginHorizontal: 30, marginVertical: 50}}>
                    <View style={{alignItems: 'center'}}>
                      <Image
                        style={{width: 40, height: 40}}
                        source={require('../../images/paginadetalhes/warning-purple.png')}
                      />
                      <Text
                        style={{
                          fontFamily: 'Poppins-Regular',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                          marginTop: 5,
                        }}>
                        Não foi encontrado resultados para:
                      </Text>
                      <Text
                        style={{
                          fontFamily: 'Poppins-Bold',
                          fontSize: 16,
                          color: '#000',
                          textAlign: 'center',
                        }}>
                        " {busca} "
                      </Text>
                    </View>
                  </View>
                </View>
              )}
            </>
          }
          onEndReached={() => {
            setAdditem(additem + 1);
          }}
          onEndReachedThreshold={0.15}
          ListFooterComponent={
            <>
              {loading && additem > 3 ? (
                <View
                  style={{
                    marginBottom: 10,
                    alignItems: 'center',
                    justifyContent: 'center',
                  }}>
                  <ActivityIndicator size={35} color="#910046" />
                </View>
              ) : (
                <View style={{marginBottom: 45}}></View>
              )}
            </>
          }
        />
      </View>
    </View>
  );
}

const estilos = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
  },

  h1: {
    fontSize: 24,
    fontFamily: 'Poppins-Regular',
    color: '#910046',
  },
  txt: {
    fontSize: 15,
    fontFamily: 'Poppins-Regular',
    color: '#414141',
  },
  img: {
    height: 40,
    width: 40,
    resizeMode: 'contain',
  },
  input: {
    width: '85%',
    height: 48,
    fontSize: 12,
    top: 2,
    paddingLeft: 30,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
    color: '#333',
  },
  containerBusca: {
    width: '100%',
    height: 50,
    borderColor: '#E7E7E7',
    backgroundColor: '#E7E7E7',
    fontFamily: 'Poppins-Regular',
    borderRadius: 8,
  },
  imgLupa: {
    height: 25,
    width: 25,
    resizeMode: 'contain',
  },
  img2: {
    height: 15,
    width: 15,
    resizeMode: 'contain',
  },
  containerIcon: {
    height: 70,
    width: 80,
    alignItems: 'center',
  },
  txtMenu: {
    paddingTop: 10,
    fontFamily: 'Roboto-Regular',
    textAlign: 'center',
    fontSize: 12,
    color: '#111',
  },
  imgMenu: {
    height: 40,
    width: 40,
    resizeMode: 'contain',
  },
});
