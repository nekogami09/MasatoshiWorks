//
//  clearViewController.m
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "clearViewController.h"
#import "ViewController.h"

@interface clearViewController ()

@end

@implementation clearViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    //ポイントの表示
    clearTimeCountLabel.text = [NSString stringWithFormat:@"%d", _clearTimeCount];
    //clearTimeCountLabel.textAlignment = NSTextAlignmentCenter;
    
    //正解数、不正解数の表示
    correctCountLabel.text = [NSString stringWithFormat:@"%d", _clearCorrectCount];
    inCorrectCountLabel.text = [NSString stringWithFormat:@"%d", _clearInCorrectCount];
    
    //背景初期化
    backgroundImageView.frame = CGRectMake(0, 66, 324, 425);
    
    //星の表示の初期化
    UIImage *image = [UIImage imageNamed:@"crearStar.png"];
    for(int i = 0; i < 10; i++){
        CGRect rect = CGRectMake(100, 100, 100, 100);
        starImageView[i] = [[UIImageView alloc] init];
        starImageView[i].frame = rect;
        starImageView[i].image = image;
    }
    
    //[self.view addSubview:starImageView[0]];
    
    //タイマーを作動させる
    timerCount = 0;
    timer = [NSTimer scheduledTimerWithTimeInterval:1.0
                                             target:self selector:@selector(timerAction)
                                           userInfo:nil
                                            repeats:YES];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//タイマーによって1秒ごとに呼ばれる
- (void)timerAction{
    if([timer isValid]){
        timerCount++;
        if(timerCount%2 == 0){
            backgroundImageView.frame = CGRectMake(0, 66, 324, 425);
        }else{
             backgroundImageView.frame = CGRectMake(0-30, 66-30, 324+60, 425+60);
        }
    }
}

//view移動したときの値渡しでつかう
-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    ViewController *nextViewController = [segue destinationViewController];
    //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
    nextViewController.seOnOff = _seOnOff;
    int maxP = _maxPoint;
    if(maxP < _clearTimeCount) maxP = _clearTimeCount;
    nextViewController.maxPoint = maxP;
}

@end
